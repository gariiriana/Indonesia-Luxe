<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Checkout extends Component
{
    use WithFileUploads;

    public $cart = [];
    public $cartTotal = 0;
    public $selectedBank = 'bca';
    public $paymentProof;
    public $isProcessing = false;
    public $showSuccess = false;
    public $bookingCode = '';

    public $bankAccounts = [
        'bca' => ['name' => 'Bank BCA', 'account' => '1234567890', 'holder' => 'PT Indonesia Luxe Wisata'],
        'mandiri' => ['name' => 'Bank Mandiri', 'account' => '0987654321', 'holder' => 'PT Indonesia Luxe Wisata'],
        'bni' => ['name' => 'Bank BNI', 'account' => '1122334455', 'holder' => 'PT Indonesia Luxe Wisata'],
    ];

    public function mount()
    {
        $this->cart = session()->get('cart', []);

        if (empty($this->cart)) {
            return redirect()->route('cart');
        }

        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->cartTotal = collect($this->cart)->sum('subtotal');
    }

    public function processCheckout()
    {
        $this->validate([
            'paymentProof' => 'required|image|max:5120',
            'selectedBank' => 'required|in:bca,mandiri,bni',
        ]);

        $this->isProcessing = true;

        try {
            DB::transaction(function () {
                // Create bookings for each cart item
                foreach ($this->cart as $item) {
                    $booking = Booking::create([
                        'user_id' => Auth::id(),
                        'package_id' => $item['package_id'],
                        'travel_date' => $item['date'],
                        'travelers' => $item['travelers'],
                        'total_amount' => $item['subtotal'],
                        'status' => 'pending',
                    ]);

                    // Upload payment proof
                    $proofPath = $this->paymentProof->store('payments', 'public');

                    // Create payment record
                    Payment::create([
                        'booking_id' => $booking->id,
                        'method' => $this->selectedBank,
                        'amount' => $item['subtotal'],
                        'proof_image' => $proofPath,
                        'status' => 'pending',
                    ]);

                    $this->bookingCode = $booking->booking_code;
                }

                // Clear cart
                session()->forget('cart');
            });

            $this->showSuccess = true;
            $this->dispatch('cartUpdated');

        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Terjadi kesalahan: ' . $e->getMessage(), 'type' => 'error']);
        }

        $this->isProcessing = false;
    }

    public function render()
    {
        return view('livewire.checkout');
    }
}
