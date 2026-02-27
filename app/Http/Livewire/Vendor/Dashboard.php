<?php

namespace App\Http\Livewire\Vendor;

use Livewire\Component;
use App\Models\Package;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $activeTab = 'dashboard';
    
    // Stats
    public $totalPackages = 0;
    public $totalBookings = 0;
    public $totalRevenue = 0;
    public $pendingBookings = 0;

    public function mount()
    {
        $vendor = Auth::user()->vendor;
        
        if (!$vendor || !$vendor->isApproved()) {
            return redirect()->route('home')->with('error', 'Anda belum menjadi vendor yang disetujui.');
        }

        $this->calculateStats();
    }

    public function calculateStats()
    {
        $vendor = Auth::user()->vendor;
        
        $this->totalPackages = $vendor->packages()->count();
        $this->totalBookings = Booking::whereHas('package', function($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id);
        })->count();
        
        $this->totalRevenue = Booking::whereHas('package', function($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id);
        })->whereIn('status', ['paid', 'confirmed', 'completed'])->sum('total_amount');
        
        $this->pendingBookings = Booking::whereHas('package', function($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id);
        })->where('status', 'pending')->count();
    }

    public function getRecentBookingsProperty()
    {
        $vendor = Auth::user()->vendor;
        
        return Booking::with(['package', 'user'])
            ->whereHas('package', function($q) use ($vendor) {
                $q->where('vendor_id', $vendor->id);
            })
            ->latest()
            ->take(5)
            ->get();
    }

    public function getPackagesProperty()
    {
        $vendor = Auth::user()->vendor;
        return $vendor->packages()->withCount('bookings')->latest()->get();
    }

    public function render()
    {
        return view('livewire.vendor.dashboard');
    }
}
