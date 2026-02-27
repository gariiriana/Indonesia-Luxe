<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [PackageController::class, 'search'])->name('search');
Route::get('/tour/{package:slug}', [PackageController::class, 'show'])->name('tour.show');

// Promo
Route::get('/promo/{promoGroup}', function ($promoGroup) {
    $promoCodes = \App\Models\PromoCode::active()->where('promo_group', $promoGroup)->get();
    return view('pages.promo-detail', compact('promoCodes', 'promoGroup'));
})->name('promo.show');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Cart (Auth Required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
});

/*
|--------------------------------------------------------------------------
| Checkout & Bookings (Auth Required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [BookingController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [BookingController::class, 'store'])->name('checkout.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

/*
|--------------------------------------------------------------------------
| Profile Routes (Auth Required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/edit', [ProfileController::class, 'update'])->name('update');

    Route::get('/wishlist', [ProfileController::class, 'wishlist'])->name('wishlist');
    Route::post('/wishlist', [ProfileController::class, 'toggleWishlist'])->name('wishlist.toggle');

    Route::get('/reviews', [ProfileController::class, 'reviews'])->name('reviews');

    Route::get('/participants', [ProfileController::class, 'participants'])->name('participants');
    Route::post('/participants', [ProfileController::class, 'storeParticipant'])->name('participants.store');
    Route::delete('/participants/{participant}', [ProfileController::class, 'destroyParticipant'])->name('participants.destroy');

    Route::get('/delivery', [ProfileController::class, 'delivery'])->name('delivery');
    Route::put('/delivery', [ProfileController::class, 'updateDelivery'])->name('delivery.update');

    Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    Route::put('/settings', [ProfileController::class, 'updateSettings'])->name('settings.update');

    Route::get('/promo-codes', [ProfileController::class, 'promoCodes'])->name('promo-codes');
    Route::get('/luxe-points', [ProfileController::class, 'luxePoints'])->name('luxe-points');
    Route::get('/gift-cards', [ProfileController::class, 'giftCards'])->name('gift-cards');
});

/*
|--------------------------------------------------------------------------
| Reviews (Auth Required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

/*
|--------------------------------------------------------------------------
| Vendor Routes
|--------------------------------------------------------------------------
*/
Route::get('/vendor-pending', [VendorController::class, 'pending'])->name('vendor.pending')->middleware('auth');

Route::middleware(['auth', 'vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
    Route::get('/packages/create', [VendorController::class, 'createPackage'])->name('packages.create');
    Route::post('/packages', [VendorController::class, 'storePackage'])->name('packages.store');
    Route::get('/packages/{package}/edit', [VendorController::class, 'editPackage'])->name('packages.edit');
    Route::put('/packages/{package}', [VendorController::class, 'updatePackage'])->name('packages.update');
    Route::delete('/packages/{package}', [VendorController::class, 'destroyPackage'])->name('packages.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/ban', [AdminController::class, 'banUser'])->name('users.ban');
    Route::post('/users/{user}/unban', [AdminController::class, 'unbanUser'])->name('users.unban');

    Route::get('/packages', [AdminController::class, 'packages'])->name('packages');
    Route::post('/packages/{package}/approve', [AdminController::class, 'approvePackage'])->name('packages.approve');
    Route::post('/packages/{package}/reject', [AdminController::class, 'rejectPackage'])->name('packages.reject');

    Route::get('/vendors', [AdminController::class, 'vendors'])->name('vendors');
    Route::post('/vendors/{vendor}/approve', [AdminController::class, 'approveVendor'])->name('vendors.approve');
    Route::post('/vendors/{vendor}/reject', [AdminController::class, 'rejectVendor'])->name('vendors.reject');

    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::post('/bookings/{booking}/status', [AdminController::class, 'updateBookingStatus'])->name('bookings.status');

    Route::get('/promo-codes', [AdminController::class, 'promoCodes'])->name('promo-codes');
    Route::post('/promo-codes', [AdminController::class, 'storePromoCode'])->name('promo-codes.store');
    Route::delete('/promo-codes/{promoCode}', [AdminController::class, 'deletePromoCode'])->name('promo-codes.destroy');

    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');
    Route::delete('/reviews/{review}', [AdminController::class, 'destroyReview'])->name('reviews.destroy');
});
