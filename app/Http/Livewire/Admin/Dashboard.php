<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Package;
use App\Models\Booking;
use App\Models\Payment;

class Dashboard extends Component
{
    public $activeTab = 'dashboard';

    // Stats
    public $totalVendors = 0;
    public $totalPackages = 0;
    public $totalTransactions = 0;
    public $totalRevenue = 0;
    public $pendingVendors = 0;
    public $pendingPayments = 0;

    public function mount()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $this->calculateStats();
    }

    public function calculateStats()
    {
        $this->totalVendors = Vendor::count();
        $this->totalPackages = Package::count();
        $this->totalTransactions = Booking::whereIn('status', ['paid', 'confirmed', 'completed'])->count();
        $this->totalRevenue = Booking::whereIn('status', ['paid', 'confirmed', 'completed'])->sum('total_amount');
        $this->pendingVendors = Vendor::where('status', 'pending')->count();
        $this->pendingPayments = Payment::where('status', 'pending')->count();
    }

    public function getPendingVendorsProperty()
    {
        return Vendor::with('user')->where('status', 'pending')->latest()->take(5)->get();
    }

    public function getPendingPackagesProperty()
    {
        return Package::with(['vendor', 'category'])->where('status', 'pending')->latest()->take(5)->get();
    }

    public function getPendingPaymentsProperty()
    {
        return Payment::with(['booking.user', 'booking.package'])->where('status', 'pending')->latest()->take(5)->get();
    }

    public function approveVendor($vendorId)
    {
        $vendor = Vendor::findOrFail($vendorId);
        $vendor->update(['status' => 'approved']);
        $this->calculateStats();
        $this->dispatch('notify', ['message' => 'Vendor berhasil disetujui!', 'type' => 'success']);
    }

    public function rejectVendor($vendorId)
    {
        $vendor = Vendor::findOrFail($vendorId);
        $vendor->update(['status' => 'rejected']);
        $this->calculateStats();
        $this->dispatch('notify', ['message' => 'Vendor ditolak.', 'type' => 'info']);
    }

    public function approvePackage($packageId)
    {
        $package = Package::findOrFail($packageId);
        $package->update(['status' => 'approved']);
        $this->calculateStats();
        $this->dispatch('notify', ['message' => 'Paket berhasil disetujui!', 'type' => 'success']);
    }

    public function verifyPayment($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $payment->update([
            'status' => 'verified',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);
        
        $payment->booking->update(['status' => 'paid']);
        
        $this->calculateStats();
        $this->dispatch('notify', ['message' => 'Pembayaran berhasil diverifikasi!', 'type' => 'success']);
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
