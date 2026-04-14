@extends('layouts.app')

@section('title', 'Indonesia Luxe - Tour & Travel Premium')
@section('description', 'Platform tour & travel premium terpercaya di Indonesia. Temukan Open Trip, Private Tour, Hiking, Rafting, Snorkeling, dan banyak lagi.')

@section('content')

{{-- ═══════════════════════════════════════════════════
     HERO SECTION - Full-screen slideshow dengan search
═══════════════════════════════════════════════════ --}}
<section x-data="heroSlider()" x-init="init()" class="relative overflow-hidden" style="height: calc(100vh - 64px); min-height: 500px;">

    {{-- Background images --}}
    @php
    $heroImages = [
        'https://images.unsplash.com/photo-1594805938422-b330ad42a7bb?w=1600&q=80',
        'https://images.unsplash.com/photo-1559628233-e9287b161a30?w=1600&q=80',
        'https://images.unsplash.com/photo-1696855179868-9c40f02b4706?w=1600&q=80',
        'https://images.unsplash.com/photo-1613278103929-b945a707411a?w=1600&q=80',
        'https://images.unsplash.com/photo-1602989988967-6d763203bcbf?w=1600&q=80',
    ];
    @endphp

    @foreach($heroImages as $i => $img)
    <div class="absolute inset-0 transition-opacity duration-1000"
         :style="'opacity: ' + (currentIndex === {{ $i }} ? '1' : '0')">
        <img src="{{ $img }}" alt="Indonesia Luxe" class="w-full h-full object-cover">
    </div>
    @endforeach

    {{-- Gradient overlay --}}
    <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.3) 40%, rgba(0,0,0,0.7) 100%);"></div>

    {{-- Hero Content --}}
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4" style="transform: translateY(-5%)">

        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs px-4 py-1.5 rounded-full mb-5" data-aos="fade-down">
            <span class="w-2 h-2 bg-amber-400 rounded-full animate-pulse"></span>
            Platform Tour Premium #1 di Indonesia
        </div>

        <h1 class="text-4xl md:text-5xl lg:text-6xl text-white mb-4 drop-shadow-lg leading-tight" data-aos="fade-up">
            Jelajahi <span style="color: #F59E0B; font-family: 'Playfair Display', serif;">Keajaiban</span><br>
            <span style="font-family: 'Playfair Display', serif;">Nusantara</span>
        </h1>
        <p class="text-base md:text-lg text-gray-200 mb-8 max-w-xl" data-aos="fade-up" data-aos-delay="100">
            Ribuan paket wisata premium dari Sabang sampai Merauke menanti Anda
        </p>

        {{-- Search Bar --}}
        <form action="{{ route('search') }}" method="GET"
              class="w-full max-w-2xl" data-aos="fade-up" data-aos-delay="200">
            <div class="flex bg-white/15 backdrop-blur-xl border border-white/30 rounded-full overflow-hidden shadow-2xl">
                <div class="flex-1 relative flex items-center">
                    <i data-lucide="search" class="absolute left-5 w-5 h-5 text-white/70"></i>
                    <input type="text" name="q"
                           placeholder="Cari destinasi, aktivitas, atau paket..."
                           class="w-full pl-13 pr-4 py-4 bg-transparent text-white placeholder-white/60 outline-none text-base"
                           style="padding-left: 3rem;">
                </div>
                <button type="submit"
                        class="shrink-0 px-8 py-4 font-semibold text-white flex items-center gap-2 transition-all"
                        style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                    <span>Cari</span>
                </button>
            </div>
        </form>

        {{-- Quick Category Pills --}}
        <div class="flex flex-wrap justify-center gap-2 mt-5" data-aos="fade-up" data-aos-delay="300">
            @foreach(['Open Trip', 'Private Tour', 'Hiking', 'Snorkeling', 'Rafting'] as $quick)
            <a href="{{ route('search', ['category' => $quick]) }}"
               class="px-4 py-1.5 bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs rounded-full hover:bg-white/30 transition">
                {{ $quick }}
            </a>
            @endforeach
        </div>

        {{-- Stats --}}
        <div class="flex items-center gap-6 md:gap-10 mt-8 text-white" data-aos="fade-up" data-aos-delay="350">
            <div class="text-center">
                <div class="text-2xl md:text-3xl font-bold" style="color: #F59E0B;">500+</div>
                <div class="text-xs text-white/70 mt-0.5">Paket Tour</div>
            </div>
            <div class="w-px h-8 bg-white/30"></div>
            <div class="text-center">
                <div class="text-2xl md:text-3xl font-bold" style="color: #F59E0B;">50+</div>
                <div class="text-xs text-white/70 mt-0.5">Destinasi</div>
            </div>
            <div class="w-px h-8 bg-white/30"></div>
            <div class="text-center">
                <div class="text-2xl md:text-3xl font-bold" style="color: #F59E0B;">10K+</div>
                <div class="text-xs text-white/70 mt-0.5">Wisatawan</div>
            </div>
            <div class="w-px h-8 bg-white/30"></div>
            <div class="text-center">
                <div class="text-2xl md:text-3xl font-bold" style="color: #F59E0B;">4.9</div>
                <div class="text-xs text-white/70 mt-0.5">Rating</div>
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

{{-- ═══════════════════════════════════════════════════
     CATEGORIES SECTION
═══════════════════════════════════════════════════ --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <p class="text-amber-500 text-sm font-semibold uppercase tracking-widest mb-2">Pilihan Aktivitas</p>
            <h2 class="text-3xl font-serif text-gray-900 mb-3">Jelajahi Berdasarkan Kategori</h2>
            <p class="text-gray-500">Pilih jenis petualangan yang sesuai dengan selera Anda</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3 md:gap-4">
            @php
            $categoryIcons = [
                'Open Trip' => 'users', 'Private Tour' => 'compass', 'Hiking / Camping' => 'tent',
                'Rafting' => 'waves', 'Snorkeling / Diving' => 'ship', 'Jeep Adventure' => 'car', 'Local Experience' => 'heart'
            ];
            $categoryImages = [
                'Open Trip' => 'https://images.unsplash.com/photo-1594805938422-b330ad42a7bb?w=400&q=80',
                'Private Tour' => 'https://images.unsplash.com/photo-1728049006343-9ee0187643d5?w=400&q=80',
                'Hiking / Camping' => 'https://images.unsplash.com/photo-1607672390383-aa666b4761ea?w=400&q=80',
                'Rafting' => 'https://images.unsplash.com/photo-1711024069413-d3b1bb99cfaf?w=400&q=80',
                'Snorkeling / Diving' => 'https://images.unsplash.com/photo-1746211516723-c4cd447ec665?w=400&q=80',
                'Jeep Adventure' => 'https://images.unsplash.com/photo-1759741753063-a3d126020677?w=400&q=80',
                'Local Experience' => 'https://images.unsplash.com/photo-1769485016794-03c4834c02d9?w=400&q=80',
            ];
            @endphp

            @foreach($categories as $i => $cat)
            <div data-aos="fade-up" data-aos-delay="{{ $i * 50 }}">
                <a href="{{ route('search', ['category' => $cat->name]) }}" class="group block text-center">
                    <div class="relative overflow-hidden rounded-2xl aspect-square mb-3 shadow-md group-hover:shadow-xl transition-shadow duration-300">
                        <img src="{{ $categoryImages[$cat->name] ?? 'https://images.unsplash.com/photo-1594805938422-b330ad42a7bb?w=400' }}"
                             alt="{{ $cat->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/35 group-hover:bg-black/20 transition-all duration-300"></div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mb-1 group-hover:bg-amber-500/80 transition-colors duration-300">
                                <i data-lucide="{{ $categoryIcons[$cat->name] ?? 'map' }}" class="w-5 h-5 text-white drop-shadow-lg"></i>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xs md:text-sm text-gray-700 group-hover:text-amber-600 transition font-semibold">{{ $cat->name }}</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $cat->packages_count ?? 0 }} paket</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════
     FEATURED TOURS SECTION
═══════════════════════════════════════════════════ --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-10">
            <div data-aos="fade-right">
                <p class="text-amber-500 text-sm font-semibold uppercase tracking-widest mb-1">Pilihan Terbaik</p>
                <h2 class="text-3xl font-serif text-gray-900 mb-2">Paket Tour Populer</h2>
                <p class="text-gray-500 text-sm">Dipilih berdasarkan rating dan ulasan terbaik</p>
            </div>
            <a href="{{ route('search') }}"
               class="hidden md:flex items-center gap-2 px-5 py-2.5 border border-amber-500 text-amber-600 rounded-full hover:bg-amber-500 hover:text-white transition font-medium text-sm"
               data-aos="fade-left">
                Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6">
            @foreach($featuredPackages as $i => $package)
            <div data-aos="fade-up" data-aos-delay="{{ ($i % 4) * 60 }}">
                @include('components.tour-card', ['package' => $package])
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8 md:hidden">
            <a href="{{ route('search') }}"
               class="inline-flex items-center gap-2 bg-amber-500 text-white px-6 py-3 rounded-full hover:bg-amber-600 transition font-medium">
                Lihat Semua Tour <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════
     POPULAR DESTINATIONS SECTION
═══════════════════════════════════════════════════ --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <p class="text-amber-500 text-sm font-semibold uppercase tracking-widest mb-2">Trending</p>
            <h2 class="text-3xl font-serif text-gray-900 mb-3">Destinasi Favorit</h2>
            <p class="text-gray-500">Destinasi paling dicari wisatawan Indonesia</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 md:gap-4">
            @foreach($popularDestinations as $i => $dest)
            <a href="{{ route('search', ['q' => $dest['name']]) }}"
               class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition-all duration-300"
               style="aspect-ratio: 3/4;"
               data-aos="zoom-in" data-aos-delay="{{ $i * 50 }}">
                <img src="{{ $dest['image'] }}" alt="{{ $dest['name'] }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.1) 60%, transparent 100%);"></div>
                <div class="absolute bottom-0 left-0 right-0 p-3 text-white">
                    <h3 class="text-sm font-bold">{{ $dest['name'] }}</h3>
                    @if($dest['count'] > 0)
                    <p class="text-xs text-white/70 mt-0.5">{{ $dest['count'] }} paket</p>
                    @endif
                </div>
                <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="bg-amber-500 text-white text-xs px-2 py-1 rounded-full">Lihat</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════
     PROMO BANNER / CTA
═══════════════════════════════════════════════════ --}}
<section class="py-16 relative overflow-hidden" style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 50%, #B45309 100%);">
    {{-- Decorative circles --}}
    <div class="absolute -top-16 -right-16 w-64 h-64 bg-white/10 rounded-full"></div>
    <div class="absolute -bottom-16 -left-16 w-48 h-48 bg-white/10 rounded-full"></div>
    <div class="absolute top-1/2 right-1/4 w-24 h-24 bg-white/5 rounded-full"></div>

    <div class="max-w-7xl mx-auto px-4 relative">
        <div class="flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="text-white text-center md:text-left" data-aos="fade-right">
                <div class="inline-flex items-center gap-2 bg-white/20 border border-white/30 text-white/90 text-xs px-3 py-1 rounded-full mb-4">
                    <i data-lucide="tag" class="w-3 h-3"></i>
                    Penawaran Terbatas
                </div>
                <h2 class="text-3xl md:text-4xl font-serif mb-2">Dapatkan Promo Spesial!</h2>
                <p class="text-amber-100 text-lg">Diskon hingga 30% untuk pengguna baru & pemesanan grup</p>
                <div class="flex items-center gap-4 mt-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold">30%</div>
                        <div class="text-xs text-amber-200">Max Diskon</div>
                    </div>
                    <div class="w-px h-10 bg-white/30"></div>
                    <div class="text-center">
                        <div class="text-2xl font-bold">FREE</div>
                        <div class="text-xs text-amber-200">Konsultasi</div>
                    </div>
                    <div class="w-px h-10 bg-white/30"></div>
                    <div class="text-center">
                        <div class="text-2xl font-bold">24/7</div>
                        <div class="text-xs text-amber-200">Support</div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3" data-aos="fade-left">
                <a href="{{ route('search') }}"
                   class="px-8 py-4 bg-white text-amber-600 rounded-xl font-semibold hover:bg-amber-50 transition shadow-lg text-center">
                    Pesan Sekarang
                </a>
                @guest
                <a href="{{ route('register') }}"
                   class="px-8 py-4 border-2 border-white text-white rounded-xl font-semibold hover:bg-white/10 transition text-center">
                    Daftar Gratis
                </a>
                @endguest
                @auth
                <a href="{{ route('profile.promo-codes') }}"
                   class="px-8 py-4 border-2 border-white text-white rounded-xl font-semibold hover:bg-white/10 transition text-center">
                    Lihat Promo
                </a>
                @endauth
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════
     WHY CHOOSE US
═══════════════════════════════════════════════════ --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <p class="text-amber-500 text-sm font-semibold uppercase tracking-widest mb-2">Keunggulan Kami</p>
            <h2 class="text-3xl font-serif text-gray-900 mb-3">Mengapa Pilih Indonesia Luxe?</h2>
            <p class="text-gray-500">Kepercayaan ratusan ribu wisatawan Indonesia sejak 2020</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['icon' => 'shield-check', 'title' => 'Terpercaya & Aman', 'desc' => 'Semua vendor telah terverifikasi dan mendapat sertifikasi resmi dari kami', 'color' => 'blue'],
                ['icon' => 'headphones', 'title' => 'Support 24/7', 'desc' => 'Tim customer service kami siap membantu kapan saja, di mana saja', 'color' => 'green'],
                ['icon' => 'tag', 'title' => 'Harga Terbaik', 'desc' => 'Jaminan harga terbaik atau kami kembalikan selisihnya 2x lipat', 'color' => 'amber'],
                ['icon' => 'award', 'title' => 'Award Winning', 'desc' => 'Platform tour & travel terbaik pilihan wisatawan Indonesia', 'color' => 'purple'],
            ] as $i => $feature)
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 group"
                 data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                @php
                $colors = ['blue' => 'bg-blue-100 text-blue-500', 'green' => 'bg-green-100 text-green-500', 'amber' => 'bg-amber-100 text-amber-500', 'purple' => 'bg-purple-100 text-purple-500'];
                @endphp
                <div class="w-14 h-14 {{ $colors[$feature['color']] }} rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                    <i data-lucide="{{ $feature['icon'] }}" class="w-7 h-7"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2 text-lg">{{ $feature['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════
     TESTIMONIALS SECTION
═══════════════════════════════════════════════════ --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <p class="text-amber-500 text-sm font-semibold uppercase tracking-widest mb-2">Cerita Mereka</p>
            <h2 class="text-3xl font-serif text-gray-900 mb-3">Apa Kata Pelanggan Kami?</h2>
            <p class="text-gray-500">Bergabung dengan 10.000+ wisatawan puas yang telah menjelajah bersama kami</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['name' => 'Sari Dewi', 'role' => 'Traveler dari Jakarta', 'text' => 'Pengalaman luar biasa! Paket Bali yang saya pesan sangat sesuai ekspektasi. Guide profesional dan harga sangat worth it.', 'rating' => 5, 'avatar' => 'SD'],
                ['name' => 'Budi Santoso', 'role' => 'Fotografer dari Bandung', 'text' => 'Hiking ke Rinjani bersama Indonesia Luxe adalah pengalaman terbaik. Tim support sangat responsif dan helpful!', 'rating' => 5, 'avatar' => 'BS'],
                ['name' => 'Maya Putri', 'role' => 'Content Creator', 'text' => 'Snorkeling di Raja Ampat yang saya booking melalui Indonesia Luxe was absolutely magical. Highly recommended!', 'rating' => 5, 'avatar' => 'MP'],
            ] as $i => $testi)
            <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-md transition" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                <div class="flex items-center gap-1 mb-4">
                    @for($s = 0; $s < $testi['rating']; $s++)
                    <i data-lucide="star" class="w-4 h-4 text-amber-400 fill-amber-400"></i>
                    @endfor
                </div>
                <p class="text-gray-600 text-sm leading-relaxed mb-5 italic">"{{ $testi['text'] }}"</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                        {{ $testi['avatar'] }}
                    </div>
                    <div>
                        <p class="text-gray-900 font-semibold text-sm">{{ $testi['name'] }}</p>
                        <p class="text-gray-400 text-xs">{{ $testi['role'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- CTA to join --}}
        @guest
        <div class="text-center mt-12" data-aos="fade-up">
            <p class="text-gray-500 mb-4">Bergabunglah dengan ribuan wisatawan lainnya</p>
            <a href="{{ route('register') }}"
               class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-8 py-4 rounded-full font-semibold transition shadow-lg shadow-amber-200">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
                Daftar Sekarang — Gratis!
            </a>
        </div>
        @endguest
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
            }, 4000);
        }
    }
}
</script>
@endpush
