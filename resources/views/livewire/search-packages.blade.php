<div>
    <!-- Search Header -->
    <div class="bg-white border-b sticky top-16 z-30">
        <div class="w-full px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                <!-- Search Input -->
                <div class="relative flex-1 max-w-xl w-full">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari paket wisata..."
                        class="w-full pl-10 pr-10 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    >
                    @if($search)
                        <button wire:click="$set('search', '')" class="absolute right-3 top-1/2 -translate-y-1/2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    @endif
                </div>

                <!-- Sort -->
                <div class="flex gap-2 w-full sm:w-auto">
                    <select wire:model.live="sortBy" class="px-4 py-3 border border-gray-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-primary-500">
                        <option value="recommended">Rekomendasi</option>
                        <option value="price-low">Harga: Rendah ke Tinggi</option>
                        <option value="price-high">Harga: Tinggi ke Rendah</option>
                        <option value="rating">Rating Tertinggi</option>
                        <option value="popular">Paling Populer</option>
                    </select>

                    <!-- Mobile Filter Toggle -->
                    <button 
                        x-data="{ open: false }"
                        @click="open = !open"
                        class="lg:hidden px-4 py-3 border border-gray-200 rounded-xl text-sm bg-white flex items-center gap-2"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filter
                    </button>
                </div>
            </div>

            <!-- Active Filters -->
            @if(!empty($selectedCategories) || !empty($selectedDestinations) || $minRating > 0)
                <div class="flex flex-wrap gap-2 mt-4">
                    @foreach($selectedCategories as $catId)
                        @php $cat = $categories->find($catId); @endphp
                        @if($cat)
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-primary-100 text-primary-700 text-sm rounded-full">
                                {{ $cat->name }}
                                <button wire:click="toggleCategory({{ $catId }})" class="hover:text-primary-900">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </span>
                        @endif
                    @endforeach
                    @foreach($selectedDestinations as $destId)
                        @php $dest = $destinations->find($destId); @endphp
                        @if($dest)
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-primary-100 text-primary-700 text-sm rounded-full">
                                {{ $dest->name }}
                                <button wire:click="toggleDestination({{ $destId }})" class="hover:text-primary-900">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </span>
                        @endif
                    @endforeach
                    @if($minRating > 0)
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-primary-100 text-primary-700 text-sm rounded-full">
                            Rating {{ $minRating }}+
                            <button wire:click="setRating(0)" class="hover:text-primary-900">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </span>
                    @endif
                    <button wire:click="clearFilters" class="text-sm text-gray-500 hover:text-primary-600 underline">
                        Hapus semua
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Results -->
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex gap-8">
            <!-- Sidebar Filter - Desktop -->
            <aside class="hidden lg:block w-64 flex-shrink-0">
                <div class="sticky top-32 bg-white rounded-xl p-6 shadow-sm">
                    <h3 class="font-bold text-lg mb-4">Filter</h3>
                    
                    <!-- Categories -->
                    <div class="mb-6">
                        <h4 class="font-semibold mb-3">Kategori</h4>
                        <div class="space-y-2">
                            @foreach($categories as $category)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        wire:click="toggleCategory({{ $category->id }})"
                                        {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}
                                        class="w-4 h-4 text-primary-500 rounded focus:ring-primary-500"
                                    >
                                    <span class="text-sm">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Destinations -->
                    <div class="mb-6">
                        <h4 class="font-semibold mb-3">Destinasi</h4>
                        <div class="space-y-2">
                            @foreach($destinations as $destination)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        wire:click="toggleDestination({{ $destination->id }})"
                                        {{ in_array($destination->id, $selectedDestinations) ? 'checked' : '' }}
                                        class="w-4 h-4 text-primary-500 rounded focus:ring-primary-500"
                                    >
                                    <span class="text-sm">{{ $destination->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="mb-6">
                        <h4 class="font-semibold mb-3">Rating Minimum</h4>
                        <div class="space-y-2">
                            @foreach([4.5, 4.0, 3.5, 3.0] as $rating)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input 
                                        type="radio" 
                                        name="rating"
                                        wire:click="setRating({{ $rating }})"
                                        {{ $minRating == $rating ? 'checked' : '' }}
                                        class="w-4 h-4 text-primary-500"
                                    >
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="text-sm">{{ $rating }}+</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <button wire:click="clearFilters" class="w-full py-2 border border-gray-200 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                        Hapus Filter
                    </button>
                </div>
            </aside>

            <!-- Results Grid -->
            <div class="flex-1">
                <div class="mb-4 flex items-center justify-between">
                    <p class="text-gray-600">
                        Menampilkan <span class="font-semibold">{{ $packages->total() }}</span> paket wisata
                    </p>
                </div>

                @if($packages->isEmpty())
                    <div class="text-center py-16">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-dark mb-2">Tidak ada hasil</h3>
                        <p class="text-gray-600 mb-4">Coba ubah filter atau kata kunci pencarian Anda</p>
                        <button wire:click="clearFilters" class="px-4 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            Hapus Filter
                        </button>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($packages as $package)
                            <a 
                                href="{{ route('package.show', $package->slug) }}"
                                class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all cursor-pointer hover:-translate-y-1 border border-gray-100"
                            >
                                <!-- Image -->
                                <div class="relative aspect-[3/2] overflow-hidden">
                                    <img 
                                        src="{{ $package->image }}" 
                                        alt="{{ $package->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        onerror="this.src='https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80'"
                                    >
                                    <div class="absolute top-3 left-3 bg-secondary-500 text-white text-xs font-bold px-2 py-1 rounded">
                                        {{ $package->discount_percentage }}% OFF
                                    </div>
                                    <div class="absolute bottom-3 right-3 bg-white/90 backdrop-blur px-2 py-1 rounded flex items-center gap-1">
                                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="text-sm font-medium">{{ $package->rating }}</span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="p-4">
                                    <h3 class="font-bold text-dark mb-2 line-clamp-1 group-hover:text-primary-600 transition-colors">
                                        {{ $package->title }}
                                    </h3>
                                    <div class="flex items-center gap-4 text-gray-500 text-sm mb-3">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $package->destination->name }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $package->duration }}
                                        </span>
                                    </div>
                                    <div class="flex items-end justify-between">
                                        <div>
                                            <span class="text-gray-400 text-sm line-through">{{ $package->formatted_original_price }}</span>
                                            <div class="text-primary-600 font-bold text-lg">{{ $package->formatted_price }}</div>
                                        </div>
                                        <span class="text-gray-500 text-sm">{{ $package->review_count }} reviews</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $packages->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
