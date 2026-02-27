<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\GiftCard;
use App\Models\LuxePoint;
use App\Models\Participant;
use App\Models\PromoCode;
use App\Models\Review;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load(['bookings', 'reviews']);
        $bookingsCount = $user->bookings->count();
        $reviewsCount = $user->reviews->count();
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();
        $luxePoints = LuxePoint::where('user_id', $user->id)->sum('points');

        return view('pages.profile.index', compact('user', 'bookingsCount', 'reviewsCount', 'wishlistCount', 'luxePoints'));
    }

    public function edit()
    {
        return view('pages.profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->only('name', 'phone');

        if ($request->hasFile('avatar')) {
            if ($user->avatar)
                Storage::disk('public')->delete($user->avatar);
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);
        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function wishlist()
    {
        $wishlists = Wishlist::with('package.category')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('pages.profile.wishlist', compact('wishlists'));
    }

    public function toggleWishlist(Request $request)
    {
        $request->validate(['package_id' => ['required', 'exists:packages,id']]);
        $existing = Wishlist::where(['user_id' => Auth::id(), 'package_id' => $request->package_id])->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['wishlisted' => false]);
        }

        Wishlist::create(['user_id' => Auth::id(), 'package_id' => $request->package_id]);
        return response()->json(['wishlisted' => true]);
    }

    public function reviews()
    {
        $reviews = Review::with('package')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('pages.profile.reviews', compact('reviews'));
    }

    public function participants()
    {
        $participants = Participant::where('user_id', Auth::id())->get();
        return view('pages.profile.participants', compact('participants'));
    }

    public function storeParticipant(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'id_number' => ['nullable', 'string', 'max:50'],
            'id_type' => ['nullable', 'in:ktp,passport'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female'],
            'phone' => ['nullable', 'string', 'max:20'],
            'emergency_contact' => ['nullable', 'string', 'max:255'],
            'emergency_phone' => ['nullable', 'string', 'max:20'],
        ]);

        Participant::create(array_merge($request->validated(), ['user_id' => Auth::id()]));
        return back()->with('success', 'Data peserta berhasil ditambahkan!');
    }

    public function destroyParticipant(Participant $participant)
    {
        $this->authorize('delete', $participant);
        $participant->delete();
        return back()->with('success', 'Data peserta dihapus.');
    }

    public function delivery()
    {
        return view('pages.profile.delivery', ['user' => Auth::user()]);
    }

    public function updateDelivery(Request $request)
    {
        $request->validate([
            'delivery_address' => ['nullable', 'string', 'max:500'],
            'delivery_city' => ['nullable', 'string', 'max:100'],
            'delivery_province' => ['nullable', 'string', 'max:100'],
            'delivery_postal' => ['nullable', 'string', 'max:10'],
        ]);
        Auth::user()->update($request->only('delivery_address', 'delivery_city', 'delivery_province', 'delivery_postal'));
        return back()->with('success', 'Alamat pengiriman diperbarui!');
    }

    public function settings()
    {
        return view('pages.profile.settings', ['user' => Auth::user()]);
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'notif_email' => ['boolean'],
            'notif_promo' => ['boolean'],
            'notif_sms' => ['boolean'],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $user = Auth::user();

        if ($request->new_password) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama salah.']);
            }
            $user->update(['password' => Hash::make($request->new_password)]);
        }

        $user->update([
            'notif_email' => $request->boolean('notif_email'),
            'notif_promo' => $request->boolean('notif_promo'),
            'notif_sms' => $request->boolean('notif_sms'),
        ]);

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }

    public function promoCodes()
    {
        $promoCodes = PromoCode::active()->get()->groupBy('promo_group');
        return view('pages.profile.promo-codes', compact('promoCodes'));
    }

    public function luxePoints()
    {
        $totalPoints = LuxePoint::where('user_id', Auth::id())->sum('points');
        $history = LuxePoint::where('user_id', Auth::id())->latest()->paginate(10);
        $pointValue = $totalPoints * 100; // 1 point = Rp 100

        return view('pages.profile.luxe-points', compact('totalPoints', 'history', 'pointValue'));
    }

    public function giftCards()
    {
        $giftCards = GiftCard::where('user_id', Auth::id())->latest()->get();
        return view('pages.profile.gift-cards', compact('giftCards'));
    }
}
