<!-- Hero Section with Video Background -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Video Background -->
    <div class="absolute inset-0">
        <video 
            autoplay 
            muted 
            loop 
            playsinline
            class="w-full h-full object-cover"
            poster="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=1920&q=80"
        >
            <source src="https://assets.mixkit.co/videos/preview/mixkit-aerial-view-of-a-beach-with-waves-1089-large.mp4" type="video/mp4">
            <!-- Fallback image if video doesn't load -->
        </video>
        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-dark/60 via-dark/40 to-dark/80"></div>
    </div>

    <!-- Floating Particles -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        @for($i = 0; $i < 20; $i++)
            <div 
                class="absolute w-2 h-2 bg-white/30 rounded-full animate-float"
                style="
                    left: {{ rand(0, 100) }}%;
                    top: {{ rand(0, 100) }}%;
                    animation-delay: {{ rand(0, 5) }}s;
                    animation-duration: {{ 5 + rand(0, 5) }}s;
                "
            ></div>
        @endfor
    </div>

    <!-- Content -->
    <div class="relative z-10 w-full px-4 sm:px-6 lg:px-8 pt-20">
        <div class="max-w-5xl mx-auto text-center">
            <!-- Badge -->
            <div 
                x-data="{ show: false }" 
                x-init="setTimeout(() => show = true, 200)"
                x-show="show"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 -translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md rounded-full border border-white/20 mb-8"
            >
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                <span class="text-white/90 text-sm font-medium">50,000+ Travelers Telah Bergabung</span>
            </div>

            <!-- Headline -->
            <div class="overflow-hidden mb-4">
                <h1 
                    x-data="{ show: false }" 
                    x-init="setTimeout(() => show = true, 400)"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-1000"
                    x-transition:enter-start="opacity-0 translate-y-full"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-bold text-white"
                >
                    Jelajahi
                </h1>
            </div>
            <div class="overflow-hidden mb-4">
                <h1 
                    x-data="{ show: false }" 
                    x-init="setTimeout(() => show = true, 550)"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-1000"
                    x-transition:enter-start="opacity-0 translate-y-full"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-bold text-white"
                >
                    Keindahan
                </h1>
            </div>
            <div class="overflow-hidden mb-8">
                <h1 
                    x-data="{ show: false }" 
                    x-init="setTimeout(() => show = true, 700)"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-1000"
                    x-transition:enter-start="opacity-0 translate-y-full"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-bold"
                >
                    <span class="gradient-text bg-gradient-to-r from-primary-400 via-accent-400 to-secondary-400 bg-clip-text text-transparent">Indonesia</span>
                </h1>
            </div>

            <!-- Subheadline -->
            <p 
                x-data="{ show: false }" 
                x-init="setTimeout(() => show = true, 900)"
                x-show="show"
                x-transition:enter="transition ease-out duration-800"
                x-transition:enter-start="opacity-0 blur-sm"
                x-transition:enter-end="opacity-100 blur-0"
                class="text-lg sm:text-xl text-white/80 mb-10 max-w-2xl mx-auto"
            >
                Temukan pengalaman wisata luar biasa dengan paket perjalanan terbaik 
                ke destinasi menakjubkan di seluruh Nusantara
            </p>

            <!-- Search Bar -->
            <div 
                x-data="{ show: false }" 
                x-init="setTimeout(() => show = true, 1100)"
                x-show="show"
                x-transition:enter="transition ease-out duration-1000"
                x-transition:enter-start="opacity-0 translate-y-10 rotate-x-90"
                x-transition:enter-end="opacity-100 translate-y-0 rotate-x-0"
                class="max-w-3xl mx-auto"
            >
                <form action="{{ route('search') }}" method="GET" class="bg-white/10 backdrop-blur-md p-2 rounded-2xl border border-white/20">
                    <div class="flex flex-col sm:flex-row gap-2">
                        <div class="flex-1 flex items-center gap-3 px-4 py-3 bg-white/10 rounded-xl">
                            <svg class="w-5 h-5 text-white/60 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <input 
                                type="text" 
                                name="search"
                                placeholder="Cari destinasi, aktivitas, atau pengalaman..."
                                class="flex-1 bg-transparent border-0 text-white placeholder-white/60 focus:ring-0 p-0"
                            >
                        </div>
                        <div class="flex gap-2">
                            <div class="flex items-center gap-2 px-4 py-3 bg-white/10 rounded-xl">
                                <svg class="w-5 h-5 text-white/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-white/80 text-sm whitespace-nowrap">Pilih Tanggal</span>
                            </div>
                            <button type="submit" class="px-6 py-3 gradient-bg text-white rounded-xl font-semibold hover:opacity-90 transition-opacity flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Stats -->
            <div 
                x-data="{ show: false }" 
                x-init="setTimeout(() => show = true, 1300)"
                x-show="show"
                x-transition:enter="transition ease-out duration-800"
                x-transition:enter-start="opacity-0 translate-y-8"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="flex flex-wrap justify-center gap-8 mt-12"
            >
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-bold text-white">50K+</div>
                    <div class="text-white/60 text-sm">Travelers</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-bold text-white">1.2K+</div>
                    <div class="text-white/60 text-sm">Paket Wisata</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-bold text-white">4.9</div>
                    <div class="text-white/60 text-sm">Rating</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-bold text-white">98%</div>
                    <div class="text-white/60 text-sm">Kepuasan</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div 
        x-data="{ show: false }" 
        x-init="setTimeout(() => show = true, 1500)"
        x-show="show"
        class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white/60"
    >
        <div class="flex flex-col items-center gap-2 animate-bounce">
            <span class="text-sm">Scroll untuk menjelajah</span>
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </div>
</section>
