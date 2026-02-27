@extends('layouts.app')

@section('title', 'Indonesia Luxe - Tour & Travel Premium')

@section('content')

{{-- ═══════════════════════════════════════════════════════════════════════
     HERO SECTION - Fullscreen slideshow
═══════════════════════════════════════════════════════════════════════ --}}
<section x-data="heroSlider()" x-init="init()" class="relative h-[calc(100vh-64px)] overflow-hidden">

    {{-- Background images --}}
    @php
    $heroImages = [
        'https://images.unsplash.com/photo-1594805938422-b330ad42a7bb?w=1600',
        'https://images.unsplash.com/photo-1559628233-e9287b161a30?w=1600',
        'https://images.unsplash.com/photo-1696855179868-9c40f02b4706?w=1600',
        'https://images.unsplash.com/photo-1613278103929-b945a707411a?w=1600',
        'https://images.unsplash.com/photo-1602989988967-6d763203bcbf?w=1600',
    ];
    @endphp

    @foreach($heroImages as $i => $img)
    <div class="absolute inset-0 transition-opacity duration-1000"
         :style="'opacity: ' + (currentIndex === {{ $i }} ? '1' : '0')">
        <img src="{{ $img }}" alt="Indonesia Luxe" class="w-full h-full object-cover">
    </div>
    @endforeach

    <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/70"></div>

    {{-- Hero Content --}}
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4" style="transform: translateY(-5%)">
        <h1 class="text-4xl md:text-6xl text-white mb-4 drop-shadow-lg"
            data-aos="fade-up">
            Jelajahi <span class="text-amber-400 font-serif">Keajaiban</span> Indonesia
        </h1>
        <p class="text-lg md:text-xl text-gray-200 mb-8 max-w-2xl" data-aos="fade-up" data-aos-delay="100">
            Ribuan paket wisata premium dari Sabang sampai Merauke menanti Anda
        </p>

        {{-- Search Bar --}}
        <form action="{{ route('search') }}" method="GET"
              class="w-full max-w-2xl" data-aos="fade-up" data-aos-delay="200">
            <div class="flex bg-white/20 backdrop-blur-xl border border-white/30 rounded-full overflow-hidden shadow-2xl">
                <div class="flex-1 relative">
                    <input type="text" name="q" placeholder="Cari destinasi, aktivitas..."
                           class="w-full px-6 py-4 bg-transparent text-white placeholder-white/60 outline-none">
                </div>
                <button type="submit"
                        class="bg-amber-500 hover:bg-amber-600 text-white px-8 py-4 flex items-center gap-2 transition shrink-0">
                    <i data-lucide="search" class="w-5 h-5"></i>
                    <span class="hidden sm:inline">Cari</span>
                </button>
            </div>
        </form>

        {{-- Stats --}}
        <div class="flex items-center gap-8 mt-10 text-white" data-aos="fade-up" data-aos-delay="300">
            <div class="text-center">
                <div class="text-2xl font-bold text-amber-400">500+</div>
                <div class="text-xs text-white/70">Paket Tour</div>
            </div>
            <div class="w-px h-8 bg-white/30"></div>
            <div class="text-center">
                <div class="text-2xl font-bold text-amber-400">50+</div>
                <div class="text-xs text-white/70">Destinasi</div>
            </div>
            <div class="w-px h-8 bg-white/30"></div>
            <div class="text-center">
                <div class="text-2xl font-bold text-amber-400">10K+</div>
                <div class="text-xs text-white/70">Wisatawan</div>
            </div>
        </div>
    </div>

    {{-- Slide dots --}}
    <div class="absolute bottom-6 left-0 right-0 flex justify-center gap-2">
        @foreach($heroImages as $i => $img)
        <button @click="currentIndex = {{ $i }}"
                :class="currentIndex === {{ $i }} ? 'bg-amber-400 w-6' : 'bg-white/50 w-2'"
                class="h-2 rounded-full transition-all duration-300"></button>
        @endforeach
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════
     CATEGORIES SECTION
═══════════════════════════════════════════════════════════════════════ --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-serif text-gray-900 mb-3">Jelajahi Berdasarkan Kategori</h2>
            <p class="text-gray-600">Pilih jenis petualangan yang sesuai dengan selera Anda</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
            @php
            $categoryIcons = [
                'Open Trip' => 'users', 'Private Tour' => 'compass', 'Hiking / Camping' => 'tent',
                'Rafting' => 'waves', 'Snorkeling / Diving' => 'ship', 'Jeep Adventure' => 'car', 'Local Experience' => 'heart'
            ];
            $categoryImages = [
                'Open Trip' => 'https://images.unsplash.com/photo-1594805938422-b330ad42a7bb?w=400',
                'Private Tour' => 'https://images.unsplash.com/photo-1728049006343-9ee0187643d5?w=400',
                'Hiking / Camping' => 'https://images.unsplash.com/photo-1607672390383-aa666b4761ea?w=400',
                'Rafting' => 'https://images.unsplash.com/photo-1711024069413-d3b1bb99cfaf?w=400',
                'Snorkeling / Diving' => 'https://images.unsplash.com/photo-1746211516723-c4cd447ec665?w=400',
                'Jeep Adventure' => 'https://images.unsplash.com/photo-1759741753063-a3d126020677?w=400',
                'Local Experience' => 'https://images.unsplash.com/photo-1769485016794-03c4834c02d9?w=400',
            ];
            @endphp

            @foreach($categories as $i => $cat)
            <div data-aos="fade-up" data-aos-delay="{{ $i * 50 }}">
                <a href="{{ route('search', ['category' => $cat->name]) }}" class="group block text-center">
                    <div class="relative overflow-hidden rounded-2xl aspect-square mb-3">
                        <img src="{{ $categoryImages[$cat->name] ?? '' }}"
                             alt="{{ $cat->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/30 group-hover:bg-black/20 transition"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i data-lucide="{{ $categoryIcons[$cat->name] ?? 'map' }}" class="w-8 h-8 text-white drop-shadow-lg"></i>
                        </div>
                    </div>
                    <h3 class="text-sm text-gray-800 group-hover:text-amber-600 transition font-medium">{{ $cat->name }}</h3>
                    <p class="text-xs text-gray-500">{{ $cat->packages_count ?? 0 }} paket</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════
     FEATURED TOURS
═══════════════════════════════════════════════════════════════════════ --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-10">
            <div data-aos="fade-right">
                <h2 class="text-3xl font-serif text-gray-900 mb-2">Paket Tour Populer</h2>
                <p class="text-gray-600">Dipilih berdasarkan rating dan ulasan terbaik</p>
            </div>
            <a href="{{ route('search') }}" class="hidden md:flex items-center gap-2 text-amber-600 hover:text-amber-700 transition" data-aos="fade-left">
                Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6">
            @foreach($featuredPackages as $i => $package)
            <div data-aos="fade-up" data-aos-delay="{{ ($i % 4) * 50 }}">
                @include('components.tour-card', ['package' => $package])
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8 md:hidden">
            <a href="{{ route('search') }}"
               class="inline-flex items-center gap-2 bg-amber-500 text-white px-6 py-3 rounded-full hover:bg-amber-600 transition">
                Lihat Semua Tour <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════
     POPULAR DESTINATIONS
═══════════════════════════════════════════════════════════════════════ --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-serif text-gray-900 mb-3">Destinasi Favorit</h2>
            <p class="text-gray-600">Destinasi paling dicari wisatawan Indonesia</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($popularDestinations as $i => $dest)
            <a href="{{ route('search', ['q' => $dest['name']]) }}"
               class="group relative overflow-hidden rounded-2xl aspect-square shadow-md hover:shadow-xl transition"
               data-aos="zoom-in" data-aos-delay="{{ $i * 50 }}">
                <img src="{{ $dest['image'] }}" alt="{{ $dest['name'] }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-3 text-white">
                    <h3 class="text-sm font-semibold">{{ $dest['name'] }}</h3>
                    @if($dest['count'] > 0)
                    <p class="text-xs text-white/70">{{ $dest['count'] }} paket</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════
     PROMO BANNER
═══════════════════════════════════════════════════════════════════════ --}}
<section class="py-16 bg-gradient-to-r from-amber-500 to-amber-600">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-white text-center md:text-left" data-aos="fade-right">
                <h2 class="text-3xl font-serif mb-2">Dapatkan Promo Spesial!</h2>
                <p class="text-amber-100 text-lg">Diskon hingga 30% untuk pengguna baru & pemesanan grup</p>
            </div>
            <div class="flex gap-3" data-aos="fade-left">
                <a href="{{ route('search') }}"
                   class="px-8 py-3.5 bg-white text-amber-600 rounded-xl font-semibold hover:bg-amber-50 transition shadow-lg">
                    Pesan Sekarang
                </a>
                @auth
                <a href="{{ route('profile.promo-codes') }}"
                   class="px-8 py-3.5 border-2 border-white text-white rounded-xl font-semibold hover:bg-white/10 transition">
                    Lihat Promo
                </a>
                @endauth
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════
     WHY CHOOSE US
═══════════════════════════════════════════════════════════════════════ --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-serif text-gray-900 mb-3">Mengapa Pilih Indonesia Luxe?</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach([
                ['icon' => 'shield-check', 'title' => 'Terpercaya & Aman', 'desc' => 'Semua vendor terverifikasi dan terpercaya'],
                ['icon' => 'headphones', 'title' => 'Support 24/7', 'desc' => 'Tim kami siap membantu kapan saja'],
                ['icon' => 'tag', 'title' => 'Harga Terbaik', 'desc' => 'Dijamin harga terbaik atau refund'],
                ['icon' => 'star', 'title' => 'Rated #1', 'desc' => 'Platform tour terbaik di Indonesia'],
            ] as $i => $feature)
            <div class="text-center p-6 bg-white rounded-2xl shadow-sm hover:shadow-md transition"
                 data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="{{ $feature['icon'] }}" class="w-7 h-7 text-amber-500"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">{{ $feature['title'] }}</h3>
                <p class="text-gray-500 text-sm">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function heroSlider() {
    return {
        currentIndex: 0,
        interval: null,
        init() {
            this.interval = setInterval(() => {
                this.currentIndex = (this.currentIndex + 1) % {{ count($heroImages) }};
            }, 3000);
        }
    }
}
</script>
@endpush
