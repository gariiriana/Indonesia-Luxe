<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CartItem;
use App\Models\Package;
use App\Models\Payment;
use App\Models\PromoCode;
use App\Models\LuxePoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $query = Booking::with(['package.category', 'payment'])
            ->where('user_id', Auth::id())
            ->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $bookings = $query->paginate(10);

        return view('pages.bookings', compact('bookings', 'status'));
    }

    public function checkout()
    {
        $items = CartItem::with('package.category')
            ->where('user_id', Auth::id())
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Keranjang Anda kosong.');
        }

        $total = $items->sum('subtotal');
        $promoCodes = PromoCode::active()->get();
        $userPoints = LuxePoint::where('user_id', Auth::id())->sum('points');

        return view('pages.checkout', compact('items', 'total', 'promoCodes', 'userPoints'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'travel_date' => ['required', 'date', 'after:today'],
            'travelers' => ['required', 'integer', 'min:1'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:bank_transfer,virtual_account,qris,credit_card,e_wallet'],
            'promo_code' => ['nullable', 'string'],
        ]);

        $items = CartItem::with('package')->where('user_id', Auth::id())->get();
        if ($items->isEmpty()) {
            return back()->with('error', 'Keranjang kosong.');
        }

        $subtotal = $items->sum('subtotal');
        $discount = 0;

        // Apply promo code
        if ($request->promo_code) {
            $promo = PromoCode::active()->where('code', strtoupper($request->promo_code))->first();
            if ($promo) {
                $validation = $promo->validate($subtotal);
                if ($validation['valid']) {
                    $discount = $promo->calculateDiscount($subtotal);
                }
            }
        }

        $total = $subtotal - $discount;

        DB::transaction(function () use ($request, $items, $total, $discount) {
            foreach ($items as $item) {
                $booking = Booking::create([
                    'user_id' => Auth::id(),
                    'package_id' => $item->package_id,
                    'travel_date' => $request->travel_date,
                    'travelers' => $request->travelers,
                    'total_amount' => $item->subtotal,
                    'status' => 'pending',
                    'special_requests' => $request->special_requests,
                ]);

                Payment::create([
                    'booking_id' => $booking->id,
                    'amount' => $item->subtotal,
                    'method' => $request->payment_method,
                    'status' => 'pending',
                    'discount' => $discount,
                ]);
            }

            // Award Luxe Points (1 point per Rp 100 spent)
            $pointsEarned = (int) ($total / 100);
            if ($pointsEarned > 0) {
                LuxePoint::create([
                    'user_id' => Auth::id(),
                    'points' => $pointsEarned,
                    'type' => 'earned',
                    'description' => 'Pembelian paket tour',
                ]);
            }

            // Clear cart
            CartItem::where('user_id', Auth::id())->delete();
        });

        return redirect()->route('bookings')->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        $booking->load(['package.category', 'payment', 'review']);
        return view('pages.booking-detail', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('update', $booking);
        if (!in_array($booking->status, ['pending', 'paid'])) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }
        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
