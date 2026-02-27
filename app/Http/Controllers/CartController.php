<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $items = CartItem::with('package.category')
            ->where('user_id', Auth::id())
            ->get();

        $total = $items->sum('subtotal');

        return view('pages.cart', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => ['required', 'exists:packages,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:20'],
            'travel_date' => ['nullable', 'date', 'after:today'],
        ]);

        $item = CartItem::updateOrCreate(
            ['user_id' => Auth::id(), 'package_id' => $request->package_id],
            ['quantity' => $request->quantity ?? 1, 'travel_date' => $request->travel_date]
        );

        return back()->with('success', 'Paket berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $this->authorize('update', $cartItem);
        $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:20']]);
        $cartItem->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function destroy(CartItem $cartItem)
    {
        $this->authorize('delete', $cartItem);
        $cartItem->delete();
        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function count()
    {
        $count = Auth::check()
            ? CartItem::where('user_id', Auth::id())->sum('quantity')
            : 0;
        return response()->json(['count' => $count]);
    }
}
