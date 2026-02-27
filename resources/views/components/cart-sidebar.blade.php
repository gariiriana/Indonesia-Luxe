<!-- Cart Sidebar -->
<div 
    x-show="cartOpen" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50"
    x-cloak
>
    <!-- Backdrop -->
    <div 
        @click="cartOpen = false"
        class="absolute inset-0 bg-black/50 backdrop-blur-sm"
    ></div>
    
    <!-- Sidebar -->
    <div 
        x-show="cartOpen"
        x-transition:enter="transform transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-2xl flex flex-col"
    >
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b">
            <h2 class="text-xl font-bold">Keranjang Belanja</h2>
            <button @click="cartOpen = false" class="p-2 hover:bg-gray-100 rounded-lg">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-6">
            @php
                $cart = session()->get('cart', []);
                $cartTotal = collect($cart)->sum('subtotal');
            @endphp
            
            @if(empty($cart))
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500">Keranjang masih kosong</p>
                    <a href="{{ route('search') }}" @click="cartOpen = false" class="inline-block mt-4 text-primary-500 hover:underline">
                        Jelajahi Paket
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($cart as $index => $item)
                        <div class="flex gap-4 p-4 bg-gray-50 rounded-xl">
                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-20 h-20 object-cover rounded-lg">
                            <div class="flex-1">
                                <h4 class="font-semibold text-sm">{{ $item['title'] }}</h4>
                                <p class="text-gray-500 text-xs">{{ $item['location'] }}</p>
                                <p class="text-gray-500 text-xs">{{ $item['date'] }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-sm">{{ $item['travelers'] }} orang</span>
                                    <span class="font-bold text-primary-600">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        
        <!-- Footer -->
        @if(!empty($cart))
            <div class="border-t p-6 space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total</span>
                    <span class="text-2xl font-bold text-primary-600">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                </div>
                <a 
                    href="{{ route('cart') }}" 
                    @click="cartOpen = false"
                    class="block w-full py-4 gradient-bg text-white text-center rounded-xl font-semibold hover:opacity-90 transition-opacity"
                >
                    Lihat Keranjang
                </a>
            </div>
        @endif
    </div>
</div>
