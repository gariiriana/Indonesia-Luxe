@extends('layouts.app')

@section('title', $package->title . ' - Indonesia Luxe')
@section('description', Str::limit($package->description, 150))

@section('content')
<div class="min-h-screen bg-gray-50">

    {{-- ── Sticky Breadcrumb Bar ── --}}
    <div class="bg-white border-b sticky top-16 z-30 shadow-sm">
        <div class="max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto py-3.5">
            <div class="flex items-center justify-between">
                <a href="{{ url()->previous() }}" class="flex items-center gap-2 text-gray-500 hover:text-amber-600 transition text-sm font-medium">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali
                </a>
                <div class="flex items-center gap-2">
                    {{-- Share --}}
                    <button onclick="navigator.clipboard.writeText(window.location.href).then(()=>alert('Link disalin!'))"
                            class="p-2 hover:bg-gray-100 rounded-lg transition text-gray-500 hover:text-gray-700" title="Share">
                        <i data-lucide="share-2" class="w-4 h-4"></i>
                    </button>
                    {{-- Wishlist --}}
                    @auth
                    <button class="p-2 hover:bg-red-50 rounded-lg transition text-gray-500 hover:text-red-500" title="Simpan">
                        <i data-lucide="heart" class="w-4 h-4"></i>
                    </button>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- ── Hero Image ── --}}
    <div class="relative" style="height: 420px;">
        <img
            src="{{ $package->image }}"
            alt="{{ $package->title }}"
            class="w-full h-full object-cover"
            onerror="this.src='https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&q=80'"
        >
        <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);"></div>

        {{-- Hero overlay content --}}
        <div class="absolute bottom-0 left-0 right-0">
            <div class="max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto pb-8">
                {{-- Badges --}}
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    <span class="inline-block bg-amber-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $package->category->name ?? 'Tour' }}
                    </span>
                    @if($package->discount_percentage > 0)
                    <span class="inline-block bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                        {{ $package->discount_percentage }}% OFF
                    </span>
                    @endif
                </div>

                <h1 class="text-2xl md:text-4xl font-bold text-white mb-3 leading-tight">
                    {{ $package->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-4 text-white/90 text-sm">
                    <span class="flex items-center gap-1.5">
                        <i data-lucide="map-pin" class="w-4 h-4 text-amber-400"></i>
                        {{ $package->destination->name ?? 'Indonesia' }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <i data-lucide="clock" class="w-4 h-4 text-amber-400"></i>
                        {{ $package->duration }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <i data-lucide="star" class="w-4 h-4 text-amber-400 fill-amber-400"></i>
                        <strong>{{ $package->rating }}</strong>
                        <span class="text-white/60">({{ $package->review_count }} ulasan)</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Content ── --}}
    <div class="max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto py-8">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- ── Main Content ── --}}
            <div class="flex-1 min-w-0">

                {{-- Quick Info Cards --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                    @foreach([
                        ['icon' => 'clock', 'label' => 'Durasi', 'value' => $package->duration],
                        ['icon' => 'users', 'label' => 'Grup', 'value' => 'Min. 2 orang'],
                        ['icon' => 'map-pin', 'label' => 'Destinasi', 'value' => $package->destination->name ?? 'Indonesia'],
                        ['icon' => 'star', 'label' => 'Rating', 'value' => $package->rating . '/5.0'],
                    ] as $info)
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 text-center">
                        <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <i data-lucide="{{ $info['icon'] }}" class="w-4 h-4 text-amber-500"></i>
                        </div>
                        <p class="text-xs text-gray-400 mb-0.5">{{ $info['label'] }}</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $info['value'] }}</p>
                    </div>
                    @endforeach
                </div>

                {{-- Tabs --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ activeTab: 'overview' }">
                    {{-- Tab Nav --}}
                    <div class="flex border-b border-gray-100">
                        <button @click="activeTab = 'overview'"
                                :class="activeTab === 'overview' ? 'border-b-2 border-amber-500 text-amber-600 bg-amber-50/50' : 'text-gray-500 hover:text-gray-700'"
                                class="flex-1 md:flex-none px-5 py-4 font-semibold text-sm transition flex items-center justify-center gap-2">
                            <i data-lucide="info" class="w-4 h-4"></i>
                            <span>Ikhtisar</span>
                        </button>
                        <button @click="activeTab = 'itinerary'"
                                :class="activeTab === 'itinerary' ? 'border-b-2 border-amber-500 text-amber-600 bg-amber-50/50' : 'text-gray-500 hover:text-gray-700'"
                                class="flex-1 md:flex-none px-5 py-4 font-semibold text-sm transition flex items-center justify-center gap-2">
                            <i data-lucide="map" class="w-4 h-4"></i>
                            <span>Itinerary</span>
                        </button>
                        <button @click="activeTab = 'inclusions'"
                                :class="activeTab === 'inclusions' ? 'border-b-2 border-amber-500 text-amber-600 bg-amber-50/50' : 'text-gray-500 hover:text-gray-700'"
                                class="flex-1 md:flex-none px-5 py-4 font-semibold text-sm transition flex items-center justify-center gap-2">
                            <i data-lucide="check-square" class="w-4 h-4"></i>
                            <span>Termasuk</span>
                        </button>
                    </div>

                    {{-- Tab Content --}}
                    <div class="p-6">
                        {{-- Overview Tab --}}
                        <div x-show="activeTab === 'overview'" x-transition>
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Tentang Paket Ini</h3>
                            <p class="text-gray-600 leading-relaxed mb-6 text-sm">{{ $package->description }}</p>

                            <h4 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                                <i data-lucide="zap" class="w-4 h-4 text-amber-500"></i>
                                Highlights
                            </h4>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                @foreach(array_slice($package->inclusions, 0, 6) as $inclusion)
                                <li class="flex items-center gap-2.5 text-gray-600 text-sm">
                                    <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                                        <i data-lucide="check" class="w-3 h-3 text-green-600"></i>
                                    </div>
                                    {{ $inclusion }}
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Itinerary Tab --}}
                        <div x-show="activeTab === 'itinerary'" x-transition x-cloak>
                            <h3 class="text-lg font-bold text-gray-900 mb-5">Rencana Perjalanan</h3>
                            <div class="space-y-0">
                                @foreach($package->itinerary as $i => $day)
                                <div class="flex gap-4 pb-6 relative">
                                    {{-- Timeline line --}}
                                    @if(!$loop->last)
                                    <div class="absolute left-5 top-10 bottom-0 w-px bg-amber-200"></div>
                                    @endif
                                    {{-- Day number --}}
                                    <div class="w-10 h-10 bg-amber-500 text-white rounded-full flex items-center justify-center text-sm font-bold shrink-0 z-10">
                                        {{ $day['day'] }}
                                    </div>
                                    {{-- Content --}}
                                    <div class="flex-1 bg-gray-50 rounded-xl p-4">
                                        <h4 class="font-bold text-gray-900 mb-2">{{ $day['title'] }}</h4>
                                        <ul class="space-y-1.5">
                                            @foreach($day['activities'] as $activity)
                                            <li class="flex items-center gap-2 text-gray-600 text-sm">
                                                <div class="w-1.5 h-1.5 bg-amber-400 rounded-full shrink-0"></div>
                                                {{ $activity }}
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Inclusions Tab --}}
                        <div x-show="activeTab === 'inclusions'" x-transition x-cloak>
                            <h3 class="text-lg font-bold text-gray-900 mb-5">Yang Termasuk dalam Paket</h3>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($package->inclusions as $inclusion)
                                <li class="flex items-center gap-3 text-gray-600 text-sm bg-green-50 rounded-lg p-3">
                                    <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                                        <i data-lucide="check" class="w-3.5 h-3.5 text-green-600"></i>
                                    </div>
                                    {{ $inclusion }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Booking Sidebar ── --}}
            <div class="lg:w-96 shrink-0">
                <div class="sticky top-24">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

                        {{-- Price Header --}}
                        <div class="p-6 border-b border-gray-100" style="background: linear-gradient(135deg, #fffbeb, #fff7ed);">
                            <div class="flex items-center gap-2 mb-1">
                                @if($package->discount_percentage > 0)
                                <span class="text-gray-400 text-sm line-through">{{ $package->formatted_original_price }}</span>
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                                    {{ $package->discount_percentage }}% OFF
                                </span>
                                @endif
                            </div>
                            <div class="text-3xl font-bold text-amber-600">
                                {{ $package->formatted_price }}
                            </div>
                            <span class="text-gray-400 text-sm">/orang</span>
                        </div>

                        {{-- Booking Form --}}
                        <div class="p-6">
                            <form action="{{ route('cart') }}" method="GET" class="space-y-4">
                                <input type="hidden" name="package_id" value="{{ $package->id }}">

                                {{-- Date --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                        <i data-lucide="calendar" class="w-4 h-4 inline mr-1 text-amber-500"></i>
                                        Tanggal Keberangkatan
                                    </label>
                                    <input type="date" name="date"
                                           min="{{ date('Y-m-d') }}"
                                           required
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none text-sm">
                                </div>

                                {{-- Travelers Counter --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                        <i data-lucide="users" class="w-4 h-4 inline mr-1 text-amber-500"></i>
                                        Jumlah Traveler
                                    </label>
                                    <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden">
                                        <button type="button" onclick="decrementTravelers()"
                                                class="w-12 h-12 flex items-center justify-center hover:bg-gray-50 transition text-gray-600 font-bold text-lg">
                                            −
                                        </button>
                                        <input type="number" name="travelers" id="travelers"
                                               value="1" min="1" readonly
                                               class="flex-1 text-center font-bold text-lg text-gray-800 border-0 outline-none bg-transparent py-3">
                                        <button type="button" onclick="incrementTravelers()"
                                                class="w-12 h-12 flex items-center justify-center hover:bg-amber-50 transition text-amber-600 font-bold text-lg">
                                            +
                                        </button>
                                    </div>
                                </div>

                                {{-- Total --}}
                                <div class="flex justify-between items-center py-3 border-t border-gray-100">
                                    <span class="text-gray-600 font-medium">Total Pembayaran</span>
                                    <span class="text-xl font-bold text-amber-600" id="total-price">
                                        {{ $package->formatted_price }}
                                    </span>
                                </div>

                                {{-- Tambah ke Keranjang --}}
                                @auth
                                <button type="submit"
                                        class="w-full text-white py-4 rounded-xl font-semibold transition text-sm shadow-lg"
                                        style="background: linear-gradient(135deg, #F59E0B, #D97706);"
                                        onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                    <i data-lucide="shopping-cart" class="w-4 h-4 inline mr-2"></i>
                                    Tambah ke Keranjang
                                </button>
                                @else
                                <a href="{{ route('login') }}"
                                   class="w-full text-white py-4 rounded-xl font-semibold transition text-sm shadow-lg flex items-center justify-center gap-2"
                                   style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                                    <i data-lucide="log-in" class="w-4 h-4"></i>
                                    Masuk untuk Memesan
                                </a>
                                @endauth

                                {{-- View Cart --}}
                                <a href="{{ route('cart') }}"
                                   class="block w-full text-center py-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition text-sm text-gray-600">
                                    Lihat Keranjang
                                </a>
                            </form>

                            {{-- Guarantee --}}
                            <div class="mt-4 pt-4 border-t border-gray-100 space-y-2">
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-green-500 shrink-0"></i>
                                    Gratis pembatalan hingga 24 jam sebelum keberangkatan
                                </div>
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <i data-lucide="headphones" class="w-3.5 h-3.5 text-blue-500 shrink-0"></i>
                                    Support 24/7 selama perjalanan Anda
                                </div>
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <i data-lucide="tag" class="w-3.5 h-3.5 text-amber-500 shrink-0"></i>
                                    Harga terbaik atau kami refund selisihnya
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Vendor info --}}
                    @if($package->vendor)
                    <div class="mt-4 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                            <i data-lucide="store" class="w-5 h-5 text-amber-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Dijual oleh</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $package->vendor->name }}</p>
                        </div>
                        <div class="ml-auto">
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-medium">
                                <i data-lucide="check-circle" class="w-3 h-3 inline mr-0.5"></i>
                                Terverifikasi
                            </span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const pricePerPerson = {{ $package->discounted_price }};

    function incrementTravelers() {
        const input = document.getElementById('travelers');
        input.value = parseInt(input.value) + 1;
        updateTotal();
    }

    function decrementTravelers() {
        const input = document.getElementById('travelers');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            updateTotal();
        }
    }

    function updateTotal() {
        const travelers = parseInt(document.getElementById('travelers').value);
        const total = pricePerPerson * travelers;
        document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
</script>
@endsection
