@extends('layouts.app')

@section('title', 'Keranjang Saya - Indonesia Luxe')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-serif text-gray-900 mb-6">Keranjang Saya</h1>

        @if($items->isEmpty())
            <div class="text-center py-20 bg-white rounded-2xl shadow-sm">
                <i data-lucide="shopping-cart" class="w-16 h-16 text-gray-200 mx-auto mb-4"></i>
                <h3 class="text-xl text-gray-500 mb-2">Keranjang Anda kosong</h3>
                <p class="text-gray-400 mb-6">Mulai tambahkan paket tour yang Anda inginkan</p>
                <a href="{{ route('search') }}"
                    class="inline-flex items-center gap-2 bg-amber-500 text-white px-6 py-3 rounded-xl hover:bg-amber-600 transition">
                    <i data-lucide="search" class="w-5 h-5"></i> Cari Tour
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Cart Items --}}
                <div class="lg:col-span-2 space-y-4">
                    @foreach($items as $item)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                            <div class="flex gap-4">
                                <img src="{{ $item->package->image }}" alt="{{ $item->package->title }}"
                                    class="w-24 h-24 rounded-xl object-cover shrink-0">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <span
                                                class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">{{ $item->package->category->name }}</span>
                                            <h3 class="mt-1 font-medium text-gray-900 line-clamp-2">{{ $item->package->title }}</h3>
                                            <p class="text-sm text-gray-500 mt-0.5">{{ $item->package->duration }}</p>
                                            @if($item->travel_date)
                                                <p class="text-sm text-amber-600 mt-0.5 flex items-center gap-1">
                                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                                    {{ $item->travel_date->format('d M Y') }}
                                                </p>
                                            @endif
                                        </div>
                                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 hover:bg-red-50 rounded-lg transition text-gray-400 hover:text-red-500">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="flex items-center justify-between mt-3">
                                        <form action="{{ route('cart.update', $item) }}" method="POST"
                                            class="flex items-center gap-2">
                                            @csrf @method('PATCH')
                                            <span class="text-sm text-gray-600">Jumlah:</span>
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="20"
                                                onchange="this.form.submit()"
                                                class="w-16 border border-gray-200 rounded-lg px-2 py-1 text-center text-sm focus:ring-amber-500 focus:border-amber-500">
                                        </form>
                                        <div class="text-right">
                                            <p class="text-amber-600 font-semibold">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </p>
                                            <p class="text-xs text-gray-400">Rp
                                                {{ number_format($item->package->discounted_price, 0, ',', '.') }}/pax</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Order Summary --}}
                <div>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sticky top-20">
                        <h2 class="font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>
                        <div class="space-y-3 mb-4">
                            @foreach($items as $item)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600 line-clamp-1 flex-1">{{ $item->package->title }}
                                        (×{{ $item->quantity }})</span>
                                    <span class="text-gray-900 ml-2 shrink-0">Rp
                                        {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="border-t border-gray-100 pt-3 mb-5">
                            <div class="flex items-center justify-between font-semibold">
                                <span class="text-gray-900">Total</span>
                                <span class="text-amber-600 text-lg">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('checkout') }}"
                            class="block w-full bg-amber-500 hover:bg-amber-600 text-white py-3.5 rounded-xl font-semibold text-center transition">
                            Lanjut ke Checkout
                        </a>
                        <a href="{{ route('search') }}" class="block text-center text-sm text-amber-600 hover:underline mt-3">
                            ← Tambah lagi
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection