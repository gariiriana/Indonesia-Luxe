<!-- Popular Packages Section -->
<section id="packages" class="py-20 lg:py-28 bg-white relative overflow-hidden">
    <!-- Wave Divider -->
    <div class="absolute top-0 left-0 right-0 h-20 bg-light">
        <svg viewBox="0 0 1440 120" class="absolute bottom-0 w-full h-20" preserveAspectRatio="none">
            <path fill="white" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,64C960,75,1056,85,1152,80C1248,75,1344,53,1392,42.7L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"/>
        </svg>
    </div>

    <div class="w-full px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-12">
            <div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-dark mb-4">
                    Paket Wisata <span class="gradient-text">Populer</span>
                </h2>
                <p class="text-gray-600 text-lg max-w-xl">
                    Pilihan terbaik dengan rating tertinggi dari traveler kami
                </p>
            </div>

            <!-- Navigation Arrows -->
            <div class="flex gap-2 mt-4 sm:mt-0">
                <button onclick="scrollPackages('left')" class="w-12 h-12 rounded-full border-2 border-gray-200 hover:border-primary-500 hover:bg-primary-500 hover:text-white transition-all flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button onclick="scrollPackages('right')" class="w-12 h-12 rounded-full border-2 border-gray-200 hover:border-primary-500 hover:bg-primary-500 hover:text-white transition-all flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Carousel -->
        <div id="packages-carousel" class="flex gap-6 overflow-x-auto scrollbar-hide pb-4 snap-x snap-mandatory">
            @foreach($popularPackages as $package)
                <div class="group flex-shrink-0 w-[340px] snap-start bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer hover:-translate-y-2 border border-gray-100">
                    <!-- Image -->
                    <div class="relative aspect-[3/2] overflow-hidden">
                        <img 
                            src="{{ $package->image }}" 
                            alt="{{ $package->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            onerror="this.src='https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80'"
                        >
                        <!-- Discount Badge -->
                        <div class="absolute top-4 left-4 bg-secondary-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                            {{ $package->discount_percentage }}% OFF
                        </div>
                        <!-- Rating -->
                        <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full flex items-center gap-1">
                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-sm font-semibold">{{ $package->rating }}</span>
                            <span class="text-xs text-gray-500">({{ $package->review_count }})</span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-dark mb-2 line-clamp-1 group-hover:text-primary-600 transition-colors">
                            {{ $package->title }}
                        </h3>

                        <div class="flex items-center gap-4 text-gray-500 text-sm mb-4">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>{{ $package->destination->name }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $package->duration }}</span>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="flex items-end justify-between">
                            <div>
                                <div class="text-gray-400 text-sm line-through">
                                    {{ $package->formatted_original_price }}
                                </div>
                                <div class="text-primary-600 text-xl font-bold">
                                    {{ $package->formatted_price }}
                                </div>
                            </div>
                            <a href="{{ route('package.show', $package->slug) }}" class="px-4 py-2 bg-primary-500 text-white text-sm font-medium rounded-lg opacity-0 group-hover:opacity-100 transition-opacity hover:bg-primary-600">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function scrollPackages(direction) {
            const carousel = document.getElementById('packages-carousel');
            const scrollAmount = 360;
            carousel.scrollBy({
                left: direction === 'left' ? -scrollAmount : scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>
</section>
