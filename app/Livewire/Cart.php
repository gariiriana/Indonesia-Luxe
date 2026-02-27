<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;

class Cart extends Component
{
    public $cart = [];
    public $cartTotal = 0;
    public $cartCount = 0;

    protected $listeners = ['addToCart' => 'addItem', 'cartUpdated' => 'refreshCart'];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        $this->calculateTotals();
    }

    public function addItem($packageId, $date, $travelers)
    {
        $package = Package::findOrFail($packageId);

        $item = [
            'package_id' => $packageId,
            'title' => $package->title,
            'image' => $package->image,
            'location' => $package->destination->name,
            'duration' => $package->duration,
            'price' => $package->discounted_price,
            'date' => $date,
            'travelers' => $travelers,
            'subtotal' => $package->discounted_price * $travelers,
        ];

        $this->cart[] = $item;
        session()->put('cart', $this->cart);
        $this->calculateTotals();

        $this->dispatch('cartUpdated');
        $this->dispatch('notify', ['message' => 'Paket berhasil ditambahkan ke keranjang!', 'type' => 'success']);
    }

    public function removeItem($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart);
        session()->put('cart', $this->cart);
        $this->calculateTotals();

        $this->dispatch('cartUpdated');
    }

    public function updateTravelers($index, $travelers)
    {
        if ($travelers < 1)
            $travelers = 1;

        $this->cart[$index]['travelers'] = $travelers;
        $this->cart[$index]['subtotal'] = $this->cart[$index]['price'] * $travelers;

        session()->put('cart', $this->cart);
        $this->calculateTotals();
    }

    public function updateDate($index, $date)
    {
        $this->cart[$index]['date'] = $date;
        session()->put('cart', $this->cart);
    }

    public function clearCart()
    {
        $this->cart = [];
        session()->forget('cart');
        $this->calculateTotals();
        $this->dispatch('cartUpdated');
    }

    public function calculateTotals()
    {
        $this->cartTotal = collect($this->cart)->sum('subtotal');
        $this->cartCount = collect($this->cart)->sum('travelers');
    }

    public function refreshCart()
    {
        $this->cart = session()->get('cart', []);
        $this->calculateTotals();
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
