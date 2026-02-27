@extends('layouts.app')

@section('title', 'Checkout - Indonesia Luxe')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-serif text-gray-900 mb-6">Konfirmasi Pesanan</h1>

    <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf

        {{-- ── Left: Form ──────────────────────────────────────────────────────── --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Detail Perjalanan --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i data-lucide="calendar" class="w-5 h-5 text-amber-500"></i> Detail Perjalanan
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Keberangkatan <span class="text-red-500">*</span></label>
                        <input type="date" name="travel_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-amber-500 focus:border-amber-500">
                        @error('travel_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah Peserta <span class="text-red-500">*</span></label>
                        <input type="number" name="travelers" value="1" min="1" max="50" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Permintaan Khusus (opsional)</label>
                    <textarea name="special_requests" rows="3" placeholder="Alergi makanan, kebutuhan khusus, dll..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-amber-500 focus:border-amber-500 resize-none"></textarea>
                </div>
            </div>

            {{-- Kode Promo --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5"
                 x-data="promoChecker({{ $total }})">
                <h2 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i data-lucide="tag" class="w-5 h-5 text-amber-500"></i> Kode Promo
                </h2>
                <div class="flex gap-2">
                    <input type="text" x-model="code" placeholder="Masukkan kode promo"
                           class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-amber-500 focus:border-amber-500 uppercase">
                    <button type="button" @click="checkPromo()"
                            class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-medium transition">
                        Pakai
                    </button>
                </div>
                <div x-show="message" x-cloak class="mt-2 text-sm" :class="valid ? 'text-green-600' : 'text-red-500'" x-text="message"></div>
                <input type="hidden" name="promo_code" :value="valid ? code : ''">
                <div x-show="valid && discount > 0" x-cloak class="mt-3 flex items-center justify-between bg-green-50 rounded-xl px-4 py-3">
                    <span class="text-green-700 text-sm font-medium">Diskon berhasil!</span>
                    <span class="text-green-700 font-semibold" x-text="'- Rp ' + discount.toLocaleString('id-ID')"></span>
                </div>
            </div>

            {{-- Metode Pembayaran --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i data-lucide="credit-card" class="w-5 h-5 text-amber-500"></i> Metode Pembayaran
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3" x-data="{ method: 'bank_transfer' }">
                    @foreach([
                        'bank_transfer' => ['icon' => 'landmark', 'label' => 'Transfer Bank'],
                        'virtual_account' => ['icon' => 'credit-card', 'label' => 'Virtual Account'],
                        'qris' => ['icon' => 'qr-code', 'label' => 'QRIS'],
                        'credit_card' => ['icon' => 'credit-card', 'label' => 'Kartu Kredit'],
                        'e_wallet' => ['icon' => 'smartphone', 'label' => 'E-Wallet'],
                    ] as $value => $opt)
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" value="{{ $value }}" x-model="method" class="sr-only" required>
                        <div :class="method === '{{ $value }}' ? 'border-amber-500 bg-amber-50' : 'border-gray-200'"
                             class="border-2 rounded-xl p-3 text-center transition hover:border-amber-300">
                            <i data-lucide="{{ $opt['icon'] }}" class="w-5 h-5 mx-auto mb-1 text-gray-600"></i>
                            <p class="text-xs font-medium text-gray-700">{{ $opt['label'] }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── Right: Summary ──────────────────────────────────────────────────── --}}
        <div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sticky top-20">
                <h2 class="font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>
                @foreach($items as $item)
                <div class="flex gap-3 mb-3 pb-3 border-b border-gray-50 last:border-0 last:mb-0 last:pb-0">
                    <img src="{{ $item->package->image }}" alt="" class="w-12 h-12 rounded-lg object-cover shrink-0">
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 line-clamp-2">{{ $item->package->title }}</p>
                        <div class="flex justify-between mt-1">
                            <span class="text-xs text-gray-400">×{{ $item->quantity }}</span>
                            <span class="text-sm text-amber-600 font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="border-t border-gray-100 mt-3 pt-3 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-semibold text-base mt-2 pt-2 border-t border-gray-100">
                        <span>Total</span>
                        <span class="text-amber-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button type="submit"
                        class="w-full mt-4 bg-amber-500 hover:bg-amber-600 text-white py-3.5 rounded-xl font-semibold transition flex items-center justify-center gap-2">
                    <i data-lucide="check-circle" class="w-5 h-5"></i> Konfirmasi Pesanan
                </button>

                <p class="text-center text-xs text-gray-400 mt-3">
                    <i data-lucide="shield-check" class="w-3.5 h-3.5 inline mr-1 text-green-500"></i>
                    Transaksi aman & terenkripsi
                </p>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function promoChecker(subtotal) {
    return {
        code: '', message: '', valid: false, discount: 0,
        async checkPromo() {
            if (!this.code) return;
            const resp = await fetch('/api/validate-promo', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ code: this.code, subtotal })
            });
            const data = await resp.json();
            this.valid = data.valid;
            this.message = data.message ?? (data.valid ? '✓ Promo berhasil diterapkan!' : data.error);
            this.discount = data.discount ?? 0;
        }
    }
}
</script>
@endpush
