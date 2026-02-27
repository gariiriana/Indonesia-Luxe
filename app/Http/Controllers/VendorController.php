<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\Review;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function dashboard()
    {
        $vendor = Auth::user()->vendor;
        if (!$vendor || $vendor->status !== 'approved') {
            return redirect()->route('vendor.pending');
        }

        $packages = Package::with(['category', 'bookings'])
            ->where('vendor_id', $vendor->id)
            ->latest()
            ->paginate(10);

        $totalRevenue = Booking::whereHas('package', fn($q) => $q->where('vendor_id', $vendor->id))
            ->whereIn('status', ['completed', 'confirmed'])
            ->sum('total_amount');

        $totalBookings = Booking::whereHas('package', fn($q) => $q->where('vendor_id', $vendor->id))->count();
        $avgRating = Package::where('vendor_id', $vendor->id)->avg('rating') ?? 0;
        $pendingPackages = Package::where(['vendor_id' => $vendor->id, 'status' => 'pending'])->count();

        return view('pages.vendor.dashboard', compact(
            'vendor',
            'packages',
            'totalRevenue',
            'totalBookings',
            'avgRating',
            'pendingPackages'
        ));
    }

    public function pending()
    {
        return view('pages.vendor.pending');
    }

    public function createPackage()
    {
        return view('pages.vendor.create-package');
    }

    public function storePackage(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'duration' => ['required', 'string', 'max:100'],
            'original_price' => ['required', 'numeric', 'min:0'],
            'discounted_price' => ['nullable', 'numeric', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'destination_id' => ['nullable', 'exists:destinations,id'],
            'image' => ['nullable', 'image', 'max:4096'],
            'inclusions' => ['nullable', 'array'],
            'itinerary' => ['nullable', 'array'],
        ]);

        $vendor = Auth::user()->vendor;
        $data = $request->except('image', '_token');
        $data['vendor_id'] = $vendor->id;
        $data['slug'] = \Illuminate\Support\Str::slug($request->title) . '-' . uniqid();
        $data['status'] = 'pending';
        $data['discounted_price'] = $request->discounted_price ?? $request->original_price;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('packages', 'public');
        }

        Package::create($data);
        return redirect()->route('vendor.dashboard')->with('success', 'Paket berhasil dikirim untuk review admin.');
    }

    public function editPackage(Package $package)
    {
        $this->authorize('update', $package);
        return view('pages.vendor.edit-package', compact('package'));
    }

    public function updatePackage(Request $request, Package $package)
    {
        $this->authorize('update', $package);
        $data = $request->except('image', '_token');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('packages', 'public');
        }
        $package->update($data);
        return redirect()->route('vendor.dashboard')->with('success', 'Paket berhasil diperbarui!');
    }

    public function destroyPackage(Package $package)
    {
        $this->authorize('delete', $package);
        $package->delete();
        return back()->with('success', 'Paket dihapus.');
    }
}
