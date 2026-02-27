<!-- Categories Section -->
<section id="categories" class="py-20 lg:py-28 bg-white relative overflow-hidden">
    <!-- Diagonal Clip Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-primary-50/50 to-transparent"></div>

    <div class="w-full px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-12">
            <div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-dark mb-4">
                    Kategori <span class="gradient-text">Populer</span>
                </h2>
                <p class="text-gray-600 text-lg max-w-xl">
                    Jelajahi berbagai jenis perjalanan sesuai minat dan preferensi Anda
                </p>
            </div>
            <div class="mt-4 sm:mt-0">
                <div class="h-1 w-20 gradient-bg rounded-full"></div>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <a 
                    href="{{ route('search', ['category' => $category->slug]) }}"
                    class="group relative rounded-2xl overflow-hidden cursor-pointer shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2"
                >
                    <!-- Image -->
                    <div class="aspect-[4/3] overflow-hidden">
                        <img 
                            src="{{ $category->image }}" 
                            alt="{{ $category->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                            onerror="this.src='https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80'"
                        >
                    </div>

                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-dark/80 via-dark/40 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300"></div>

                    <!-- Content -->
                    <div class="absolute inset-0 flex flex-col justify-end p-6">
                        <div class="transform group-hover:translate-y-0 transition-transform duration-300">
                            <span class="inline-block px-3 py-1 bg-primary-500 text-white text-xs font-medium rounded-full mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                {{ $category->packages_count ?? $category->tour_count }} Paket
                            </span>
                            <h3 class="text-xl font-bold text-white mb-2 group-hover:text-primary-300 transition-colors">
                                {{ $category->name }}
                            </h3>
                            <p class="text-white/80 text-sm mb-4 line-clamp-2">
                                {{ $category->description }}
                            </p>
                            <div class="flex items-center text-primary-300 font-medium text-sm opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-4 group-hover:translate-x-0">
                                <span>Jelajahi</span>
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Border Effect -->
                    <div class="absolute inset-0 border-2 border-transparent group-hover:border-primary-400/50 rounded-2xl transition-colors duration-300 pointer-events-none"></div>
                </a>
            @endforeach
        </div>
    </div>
</section>
