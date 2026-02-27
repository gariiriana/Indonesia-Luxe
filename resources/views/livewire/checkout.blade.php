<div class="min-h-screen bg-gray-50 pt-24 pb-20">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <a href="{{ route('cart') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-primary-500 mb-6">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Keranjang
        </a>

        <h1 class="text-3xl font-bold text-dark mb-8">Checkout</h1>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="flex-1 space-y-6">
                <!-- Order Summary -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h3 class="text-lg font-bold mb-4">Ringkasan Pesanan</h3>
                    <div class="space-y-4">
                        @foreach($cart as $item)
                            <div class="flex justify-between items-center py-3 border-b last:border-0">
                                <div>
                                    <p class="font-medium">{{ $item['title'] }}</p>
                                    <p class="text-sm text-gray-500">{{ $item['date'] }} • {{ $item['travelers'] }} orang</p>
                                </div>
                                <p class="font-semibold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h3 class="text-lg font-bold mb-4">Metode Pembayaran</h3>
                    
                    <div class="space-y-3">
                        @foreach($bankAccounts as $key => $bank)
                            <label class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all {{ $selectedBank === $key ? 'border-primary-500 bg-primary-50' : 'border-gray-200 hover:border-gray-300' }}">
                                <input type="radio" wire:model="selectedBank" value="{{ $key }}" class="w-4 h-4 text-primary-500">
                                <div class="flex-1">
                                    <p class="font-medium">{{ $bank['name'] }}</p>
                                    <p class="text-sm text-gray-500">Transfer Bank</p>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    @if($selectedBank)
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center justify-between mb-4">
                                <span class="font-medium">{{ $bankAccounts[$selectedBank]['name'] }}</span>
                                <span class="text-sm text-gray-500">Transfer Bank</span>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm text-gray-500">Nomor Rekening</label>
                                    <div class="flex items-center gap-2">
                                        <input 
                                            type="text" 
                                            value="{{ $bankAccounts[$selectedBank]['account'] }}" 
                                            readonly 
                                            class="flex-1 font-mono text-lg bg-white border border-gray-200 rounded-lg px-3 py-2"
                                        >
                                        <button 
                                            onclick="navigator.clipboard.writeText('{{ $bankAccounts[$selectedBank]['account'] }}'); alert('Nomor rekening disalin!')"
                                            class="p-2 border border-gray-200 rounded-lg hover:bg-gray-100"
                                        >
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-500">Atas Nama</label>
                                    <input 
                                        type="text" 
                                        value="{{ $bankAccounts[$selectedBank]['holder'] }}" 
                                        readonly 
                                        class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2"
                                    >
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Total to Pay -->
                    <div class="mt-6 p-4 bg-primary-50 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Total yang harus dibayar</span>
                            <span class="text-2xl font-bold text-primary-600">
                                Rp {{ number_format($cartTotal, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Upload Proof -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h3 class="text-lg font-bold mb-4">Upload Bukti Pembayaran</h3>
                    <div 
                        class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-primary-500 transition-colors cursor-pointer"
                        x-data="{ dragging: false }"
                        @dragover.prevent="dragging = true"
                        @dragleave.prevent="dragging = false"
                        @drop.prevent="dragging = false"
                        :class="{ 'border-primary-500 bg-primary-50': dragging }"
                    >
                        @if($paymentProof)
                            <div class="space-y-4">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                                    <svg class="w-8 h-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <p class="font-medium">{{ $paymentProof->getClientOriginalName() }}</p>
                                <button type="button" wire:click="$set('paymentProof', null)" class="text-primary-500 hover:underline">
                                    Ganti File
                                </button>
                            </div>
                        @else
                            <label class="cursor-pointer block">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-gray-600 mb-2">Klik atau drag untuk upload bukti pembayaran</p>
                                <p class="text-sm text-gray-400">Format: JPG, PNG, PDF (max 5MB)</p>
                                <input type="file" wire:model="paymentProof" accept="image/*,.pdf" class="hidden">
                            </label>
                        @endif
                    </div>
                    @error('paymentProof') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:w-80">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
                    <h3 class="font-bold mb-4">Total Pembayaran</h3>
                    <div class="text-3xl font-bold text-primary-600 mb-6">
                        Rp {{ number_format($cartTotal, 0, ',', '.') }}
                    </div>

                    <button 
                        wire:click="processCheckout"
                        wire:loading.attr="disabled"
                        class="w-full bg-primary-500 hover:bg-primary-600 text-white py-4 rounded-xl font-semibold transition-colors disabled:opacity-50"
                    >
                        <span wire:loading.remove>Konfirmasi Pembayaran</span>
                        <span wire:loading>Memproses...</span>
                    </button>

                    <div class="mt-4 space-y-2 text-sm text-gray-500">
                        <p>✓ Pembayaran aman & terenkripsi</p>
                        <p>✓ Konfirmasi dalam 24 jam</p>
                        <p>✓ Refund jika dibatalkan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    @if($showSuccess)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="bg-white rounded-2xl p-8 max-w-md mx-4 text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold mb-2">Pembayaran Berhasil!</h2>
                <p class="text-gray-600 mb-4">Terima kasih! Bukti pembayaran Anda telah kami terima dan sedang diverifikasi.</p>
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <p class="text-sm text-gray-500">Nomor Pesanan</p>
                    <p class="text-xl font-bold">{{ $bookingCode }}</p>
                </div>
                <p class="text-sm text-gray-500 mb-4">Anda akan menerima email konfirmasi dalam waktu 24 jam.</p>
                <a href="{{ route('home') }}" class="block w-full bg-primary-500 text-white py-3 rounded-xl font-semibold hover:bg-primary-600 transition-colors">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    @endif
</div>
