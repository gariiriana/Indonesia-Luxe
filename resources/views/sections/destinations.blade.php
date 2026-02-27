<!-- Destinations Section -->
<section id="destinations" class="py-20 lg:py-28 bg-light relative overflow-hidden">
    <div class="w-full px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-dark mb-4">
                Destinasi <span class="gradient-text">Pilihan</span>
            </h2>
            <div class="flex justify-center mb-4">
                <div class="h-1 w-24 gradient-bg rounded-full"></div>
            </div>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Temukan keindahan destinasi terbaik Indonesia yang siap menanti petualangan Anda
            </p>
        </div>

        <!-- Destinations Masonry Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
            <!-- First item - Large -->
            @if($destinations->count() > 0)
                <a 
                    href="{{ route('search', ['destination' => $destinations[0]->slug]) }}"
                    class="group relative rounded-2xl overflow-hidden cursor-pointer shadow-lg hover:shadow-2xl transition-all duration-700 md:row-span-2"
                >
                    <div class="h-full min-h-[400px] md:min-h-full">
                        <img 
                            src="{{ $destinations[0]->image }}" 
                            alt="{{ $destinations[0]->name }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                            onerror="this.src='https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800&q=80'"
                        >
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-dark/70 via-dark/20 to-transparent"></div>
                    <div class="absolute inset-0 flex flex-col justify-end p-6">
                        <div class="flex items-center gap-2 text-white/80 text-sm mb-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ $destinations[0]->packages_count ?? $destinations[0]->tour_count }} Paket Wisata</span>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-1">
                            {{ $destinations[0]->name }}
                        </h3>
                        <p class="text-white/80">{{ $destinations[0]->tagline }}</p>
                        <div class="mt-4 flex items-center text-primary-300 font-medium opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0">
                            <span>Lihat Paket</span>
                            <svg class="w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17l9.2-9.2M17 8v9H8"/>
                            </svg>
                        </div>
                    </div>
                </a>
            @endif

            <!-- Other destinations -->
            @foreach($destinations->slice(1) as $destination)
                <a 
                    href="{{ route('search', ['destination' => $destination->slug]) }}"
                    class="group relative rounded-2xl overflow-hidden cursor-pointer shadow-lg hover:shadow-2xl transition-all duration-700"
                >
                    <div class="aspect-[4/3]">
                        <img 
                            src="{{ $destination->image }}" 
                            alt="{{ $destination->name }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                            onerror="this.src='https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80'"
                        >
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-dark/70 via-dark/20 to-transparent"></div>
                    <div class="absolute inset-0 flex flex-col justify-end p-5">
                        <div class="flex items-center gap-2 text-white/80 text-sm mb-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ $destination->packages_count ?? $destination->tour_count }} Paket</span>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-0.5">
                            {{ $destination->name }}
                        </h3>
                        <p class="text-white/80 text-sm">{{ $destination->tagline }}</p>
                    </div>
                    <div class="absolute top-4 right-4 w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-50 group-hover:scale-100">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17l9.2-9.2M17 8v9H8"/>
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
