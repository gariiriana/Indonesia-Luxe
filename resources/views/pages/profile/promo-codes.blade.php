@extends('layouts.app')
@section('title', 'Kode Promo - Indonesia Luxe')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('profile.index') }}" class="text-gray-400 hover:text-amber-600">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <h1 class="text-2xl font-serif text-gray-900">Kode Promo</h1>
        </div>
        <p class="text-gray-500 text-sm mb-6 ml-8">Gunakan kode promo saat checkout untuk mendapatkan diskon</p>

        @foreach($promoCodes as $group => $codes)
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="tag" class="w-5 h-5 text-amber-500"></i> {{ $group }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($codes as $promo)
                        <div
                            class="bg-white rounded-2xl border border-dashed border-amber-300 p-4 relative overflow-hidden hover:shadow-md transition">
                            {{-- Left accent --}}
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-amber-500 rounded-l-2xl"></div>
                            <div class="pl-3">
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-2">
                                        <span
                                            class="font-mono font-bold text-amber-700 text-lg tracking-wider">{{ $promo->code }}</span>
                                    </div>
                                    <button
                                        onclick="navigator.clipboard.writeText('{{ $promo->code }}'); this.innerHTML='<i data-lucide=\'check\' class=\'w-4 h-4\'></i>'; lucide.createIcons();"
                                        class="p-2 hover:bg-amber-50 rounded-lg transition text-amber-600" title="Salin kode">
                                        <i data-lucide="copy" class="w-4 h-4"></i>
                                    </button>
                                </div>
                                <p class="text-gray-700 text-sm font-medium mb-1">{{ $promo->label }}</p>
                                <div class="flex items-center gap-3 flex-wrap mt-2">
                                    <span class="bg-green-50 text-green-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                        {{ $promo->discount_type === 'percent' ? $promo->discount_value . '% OFF' : 'Hemat Rp ' . number_format($promo->discount_value, 0, ',', '.') }}
                                    </span>
                                    @if($promo->min_price > 0)
                                        <span class="text-xs text-gray-400">Min. Rp
                                            {{ number_format($promo->min_price, 0, ',', '.') }}</span>
                                    @endif
                                    @if($promo->category)
                                        <span
                                            class="text-xs text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">{{ $promo->category }}</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-400 mt-2">Berlaku: {{ $promo->period }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection