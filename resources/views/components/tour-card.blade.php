{{-- Reusable Tour Card Component --}}
<a href="{{ route('tour.show', $package->slug) }}" class="group block">
    <div class="bg-white rounded-xl md:rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-shadow h-full">
        <div class="relative overflow-hidden aspect-[4/3]">
            <img src="{{ $package->image ?? 'https://images.unsplash.com/photo-1594805938422-b330ad42a7bb?w=400' }}"
                alt="{{ $package->title }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

            {{-- Category Badge --}}
            <div class="absolute top-2 left-2 md:top-3 md:left-3">
                <span class="bg-amber-500 text-white text-[10px] md:text-xs px-2 md:px-3 py-0.5 md:py-1 rounded-full">
                    {{ $package->category->name ?? 'Tour' }}
                </span>
            </div>

            {{-- Discount Badge --}}
            @if($package->original_price > $package->discounted_price)
                <div class="absolute top-2 right-2 md:top-3 md:right-3">
                    <span class="bg-red-500 text-white text-[10px] md:text-xs px-2 py-0.5 rounded-full">
                        -{{ $package->discount_percentage }}%
                    </span>
                </div>
            @else
                {{-- Wishlist button --}}
                @auth
                    <div class="absolute top-2 right-2 md:top-3 md:right-3" x-data="wishlist({{ $package->id }})"
                        @click.prevent="toggle()">
                        <button :class="isWishlisted ? 'bg-red-500 hover:bg-red-600' : 'bg-white/80 hover:bg-white'"
                            class="p-1.5 md:p-2 rounded-full transition">
                            <i data-lucide="heart" :class="isWishlisted ? 'fill-white text-white' : 'text-gray-600'"
                                class="w-3.5 h-3.5 md:w-4 md:h-4 transition"></i>
                        </button>
                    </div>
                @endauth
            @endif
        </div>

        <div class="p-2.5 md:p-4">
            {{-- Rating --}}
            <div class="flex items-center gap-1 text-amber-500 mb-0.5 md:mb-1">
                <i data-lucide="star" class="w-3.5 h-3.5 md:w-4 md:h-4 fill-amber-500"></i>
                <span class="text-xs md:text-sm font-medium">{{ $package->rating }}</span>
                <span class="text-gray-400 text-[10px] md:text-xs">({{ $package->review_count }})</span>
            </div>

            {{-- Title --}}
            <h3
                class="text-gray-900 text-xs md:text-base mb-0.5 md:mb-1 line-clamp-2 group-hover:text-amber-600 transition font-medium">
                {{ $package->title }}
            </h3>

            {{-- Duration --}}
            <div class="flex items-center gap-1 text-gray-500 text-[10px] md:text-sm mb-1.5 md:mb-3">
                <i data-lucide="clock" class="w-3 h-3 shrink-0"></i>
                <span>{{ $package->duration }}</span>
            </div>

            {{-- Price --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    @if($package->original_price > $package->discounted_price)
                        <div class="text-gray-400 text-[9px] md:text-xs line-through">
                            Rp {{ number_format($package->original_price, 0, ',', '.') }}
                        </div>
                    @endif
                    <span class="text-amber-600 text-xs md:text-lg font-semibold">
                        Rp {{ number_format($package->discounted_price, 0, ',', '.') }}
                    </span>
                    <span class="text-gray-400 text-[9px] md:text-xs">/pax</span>
                </div>
                <div class="mt-1 md:mt-0">
                    <span class="text-[9px] md:text-xs bg-green-50 text-green-600 px-2 py-0.5 rounded-full">
                        Tersedia
                    </span>
                </div>
            </div>
        </div>
    </div>
</a>

@push('scripts')
    <script>
        function wishlist(packageId) {
            return {
                isWishlisted: false,
                async toggle() {
                    @auth
                        const resp = await fetch('{{ route("profile.wishlist.toggle") }}', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                body: JSON.stringify({ package_id: packageId })
                            });
                            const data = await resp.json();
                            this.isWishlisted = data.wishlisted;
                            lucide.createIcons();
                    @else
                        window.location.href = '{{ route("login") }}';
                    @endauth
            }
            }
        }
    </script>
@endpush