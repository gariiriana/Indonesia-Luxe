<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\Payment;
use App\Models\PromoCode;
use App\Models\Review;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_vendors' => Vendor::where('status', 'approved')->count(),
            'total_packages' => Package::where('status', 'approved')->count(),
            'total_bookings' => Booking::count(),
            'total_revenue' => Booking::whereIn('status', ['completed', 'confirmed'])->sum('total_amount'),
            'pending_packages' => Package::where('status', 'pending')->count(),
            'pending_vendors' => Vendor::where('status', 'pending')->count(),
        ];

        $recentBookings = Booking::with(['user', 'package'])->latest()->limit(10)->get();
        $pendingPackages = Package::with(['vendor', 'category'])->where('status', 'pending')->latest()->get();
        $pendingVendors = Vendor::with('user')->where('status', 'pending')->latest()->get();

        return view('pages.admin.dashboard', compact('stats', 'recentBookings', 'pendingPackages', 'pendingVendors'));
    }

    // ── Users Management ──────────────────────────────────────────────────────
    public function users(Request $request)
    {
        $users = User::query()
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")->orWhere('email', 'like', "%{$request->search}%"))
            ->when($request->role, fn($q) => $q->where('role', $request->role))
            ->latest()
            ->paginate(20);

        return view('pages.admin.users', compact('users'));
    }

    public function banUser(User $user)
    {
        $user->update(['banned_at' => now()]);
        return back()->with('success', "User {$user->name} diblokir.");
    }

    public function unbanUser(User $user)
    {
        $user->update(['banned_at' => null]);
        return back()->with('success', "User {$user->name} diaktifkan.");
    }

    // ── Packages Management ───────────────────────────────────────────────────
    public function packages(Request $request)
    {
        $packages = Package::with(['vendor', 'category'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20);

        return view('pages.admin.packages', compact('packages'));
    }

    public function approvePackage(Package $package)
    {
        $package->update(['status' => 'approved']);
        return back()->with('success', "Paket \"{$package->title}\" diapprove.");
    }

    public function rejectPackage(Package $package)
    {
        $package->update(['status' => 'rejected']);
        return back()->with('success', "Paket \"{$package->title}\" ditolak.");
    }

    // ── Vendors Management ────────────────────────────────────────────────────
    public function vendors(Request $request)
    {
        $vendors = Vendor::with('user')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20);

        return view('pages.admin.vendors', compact('vendors'));
    }

    public function approveVendor(Vendor $vendor)
    {
        $vendor->update(['status' => 'approved']);
        return back()->with('success', "Vendor \"{$vendor->company_name}\" diapprove.");
    }

    public function rejectVendor(Vendor $vendor)
    {
        $vendor->update(['status' => 'rejected']);
        return back()->with('success', "Vendor \"{$vendor->company_name}\" ditolak.");
    }

    // ── Bookings Management ───────────────────────────────────────────────────
    public function bookings(Request $request)
    {
        $bookings = Booking::with(['user', 'package', 'payment'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20);

        return view('pages.admin.bookings', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $request->validate(['status' => ['required', 'in:pending,paid,confirmed,completed,cancelled']]);
        $booking->update(['status' => $request->status]);
        return back()->with('success', 'Status booking diperbarui.');
    }

    // ── Promo Codes Management ────────────────────────────────────────────────
    public function promoCodes()
    {
        $promoCodes = PromoCode::latest()->paginate(20);
        return view('pages.admin.promo-codes', compact('promoCodes'));
    }

    public function storePromoCode(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'unique:promo_codes,code'],
            'discount_type' => ['required', 'in:percent,flat'],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'label' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string'],
            'promo_group' => ['required', 'string'],
            'period' => ['required', 'string'],
        ]);

        PromoCode::create(array_merge($request->validated(), ['code' => strtoupper($request->code)]));
        return back()->with('success', 'Promo code berhasil dibuat!');
    }

    public function deletePromoCode(PromoCode $promoCode)
    {
        $promoCode->delete();
        return back()->with('success', 'Promo code dihapus.');
    }

    // ── Reviews Moderation ────────────────────────────────────────────────────
    public function reviews()
    {
        $reviews = Review::with(['user', 'package'])->latest()->paginate(20);
        return view('pages.admin.reviews', compact('reviews'));
    }

    public function destroyReview(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review dihapus.');
    }
}
