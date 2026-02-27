<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => ['required', 'exists:bookings,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        // Pastikan booking milik user yang login dan sudah selesai
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        if ($booking->status !== 'completed') {
            return back()->with('error', 'Anda hanya dapat memberikan review untuk booking yang selesai.');
        }
        if ($booking->review) {
            return back()->with('error', 'Anda sudah memberikan review untuk booking ini.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'package_id' => $booking->package_id,
            'booking_id' => $booking->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Update package rating average
        $package = Package::find($booking->package_id);
        $avgRating = Review::where('package_id', $package->id)->avg('rating');
        $reviewCount = Review::where('package_id', $package->id)->count();
        $package->update(['rating' => round($avgRating, 1), 'review_count' => $reviewCount]);

        return back()->with('success', 'Review berhasil dikirim. Terima kasih!');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        $review->delete();
        return back()->with('success', 'Review dihapus.');
    }
}
