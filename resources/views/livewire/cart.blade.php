<div class="min-h-screen bg-gray-50 pt-24 pb-20">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-dark mb-8">Keranjang Belanja</h1>

        @if(empty($cart))
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-dark mb-2">Keranjang Kosong</h2>
                <p class="text-gray-600 mb-6">Anda belum menambahkan paket wisata apapun</p>
                <a href="{{ route('search') }}" class="inline-block px-6 py-3 bg-primary-500 text-white rounded-xl font-medium hover:bg-primary-600 transition-colors">
                    Jelajahi Paket Wisata
                </a>
            </div>
        @else
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items -->
                <div class="flex-1 space-y-4">
                    @foreach($cart as $index => $item)
                        <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <!-- Image -->
                                <div class="w-full sm:w-48 h-32 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover">
                                </div>

                                <!-- Content -->
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-lg font-bold text-dark">{{ $item['title'] }}</h3>
                                        <button wire:click="removeItem({{ $index }})" class="text-gray-400 hover:text-red-500 transition-colors">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-3 text-gray-500 text-sm mb-4">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $item['location'] }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $item['duration'] }}
                                        </span>
                                    </div>

                                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                                        <!-- Date -->
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <input 
                                                type="date" 
                                                wire:change="updateDate({{ $index }}, $event.target.value)"
                                                value="{{ $item['date'] }}"
                                                class="w-40 h-8 text-sm border border-gray-200 rounded-lg px-2"
                                            >
                                        </div>

                                        <!-- Travelers -->
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                            </svg>
                                            <div class="flex items-center gap-2">
                                                <button wire:click="updateTravelers({{ $index }}, {{ $item['travelers'] - 1 }})" class="w-8 h-8 border border-gray-200 rounded-lg flex items-center justify-center hover:bg-gray-50">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                    </svg>
                                                </button>
                                                <span class="w-8 text-center font-medium">{{ $item['travelers'] }}</span>
                                                <button wire:click="updateTravelers({{ $index }}, {{ $item['travelers'] + 1 }})" class="w-8 h-8 border border-gray-200 rounded-lg flex items-center justify-center hover:bg-gray-50">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="text-right">
                                    <div class="text-primary-600 font-bold text-xl">
                                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                    </div>
                                    <div class="text-gray-500 text-sm">
                                        Rp {{ number_format($item['price'], 0, ',', '.') }} x {{ $item['travelers'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Clear Cart -->
                    <button wire:click="clearCart" class="text-red-500 text-sm hover:underline">
                        Kosongkan Keranjang
                    </button>
                </div>

                <!-- Summary -->
                <div class="lg:w-96">
                    <div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
                        <h3 class="text-lg font-bold mb-4">Ringkasan Pesanan</h3>

                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Biaya Admin</span>
                                <span>Gratis</span>
                            </div>
                        </div>

                        <div class="border-t pt-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold">Total</span>
                                <span class="text-2xl font-bold text-primary-600">
                                    Rp {{ number_format($cartTotal, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('checkout') }}" class="block w-full bg-primary-500 hover:bg-primary-600 text-white py-4 rounded-xl font-semibold text-center transition-colors">
                            Lanjutkan ke Pembayaran
                            <svg class="w-5 h-5 inline ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>

                        <p class="text-center text-sm text-gray-500 mt-4">
                            Gratis pembatalan hingga 24 jam sebelum keberangkatan
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
