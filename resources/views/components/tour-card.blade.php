{{-- Tour Card Component - Figma Parity --}}
<a href="{{ route('tour.show', $package->slug) }}" class="group block h-full">
    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 h-full border border-gray-100 hover:border-amber-200 hover:-translate-y-0.5">

        {{-- Image Container --}}
        <div class="relative overflow-hidden" style="aspect-ratio: 4/3;">
            <img src="{{ $package->image ?? 'https://images.unsplash.com/photo-1594805938422-b330ad42a7bb?w=400&q=80' }}"
                 alt="{{ $package->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                 onerror="this.src='https://images.unsplash.com/photo-1594805938422-b330ad42a7bb?w=400&q=80'">

            {{-- Gradient overlay at bottom --}}
            <div class="absolute bottom-0 left-0 right-0 h-1/3" style="background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);"></div>

            {{-- Category Badge --}}
            <div class="absolute top-2.5 left-2.5">
                <span class="bg-amber-500 text-white text-[10px] md:text-xs px-2.5 py-0.5 rounded-full font-medium shadow-sm">
                    {{ $package->category->name ?? 'Tour' }}
                </span>
            </div>

            {{-- Discount Badge OR Wishlist --}}
            @if($package->original_price > $package->discounted_price)
                <div class="absolute top-2.5 right-2.5">
                    <span class="bg-red-500 text-white text-[10px] md:text-xs px-2.5 py-0.5 rounded-full font-bold shadow-sm">
                        -{{ $package->discount_percentage }}%
                    </span>
                </div>
            @endif

            {{-- Wishlist button for logged in users --}}
            @auth
                @if(!($package->original_price > $package->discounted_price))
                <div class="absolute top-2.5 right-2.5" x-data="wishlist({{ $package->id }})" @click.prevent="toggle()">
                    <button :class="isWishlisted ? 'bg-red-500 text-white' : 'bg-white/90 text-gray-500 hover:text-red-500'"
                            class="p-1.5 rounded-full shadow-sm transition-all">
                        <i data-lucide="heart" :class="isWishlisted ? 'fill-white' : ''" class="w-4 h-4"></i>
                    </button>
                </div>
                @endif
            @endauth

            {{-- Duration on image --}}
            <div class="absolute bottom-2 right-2">
                <span class="bg-black/50 backdrop-blur-sm text-white text-[10px] px-2 py-0.5 rounded-full flex items-center gap-1">
                    <i data-lucide="clock" class="w-2.5 h-2.5"></i>
                    {{ $package->duration }}
                </span>
            </div>
        </div>

        {{-- Card Body --}}
        <div class="p-3 md:p-4">
            {{-- Rating --}}
            <div class="flex items-center gap-1 mb-1.5">
                <i data-lucide="star" class="w-3.5 h-3.5 text-amber-400 fill-amber-400"></i>
                <span class="text-xs md:text-sm font-semibold text-gray-700">{{ $package->rating }}</span>
                <span class="text-gray-400 text-[10px] md:text-xs">({{ $package->review_count }} ulasan)</span>
            </div>

            {{-- Title --}}
            <h3 class="text-gray-900 text-xs md:text-sm font-semibold mb-2 line-clamp-2 group-hover:text-amber-600 transition leading-snug">
                {{ $package->title }}
            </h3>

            {{-- Location --}}
            @if($package->destination)
            <div class="flex items-center gap-1 text-gray-400 text-[10px] md:text-xs mb-3">
                <i data-lucide="map-pin" class="w-3 h-3 shrink-0"></i>
                <span class="truncate">{{ $package->destination->name }}</span>
            </div>
            @endif

            {{-- Price + CTA --}}
            <div class="flex items-end justify-between">
                <div>
                    @if($package->original_price > $package->discounted_price)
                    <div class="text-gray-400 text-[9px] md:text-xs line-through">
                        Rp {{ number_format($package->original_price, 0, ',', '.') }}
                    </div>
                    @endif
                    <span class="text-amber-600 text-sm md:text-base font-bold">
                        Rp {{ number_format($package->discounted_price, 0, ',', '.') }}
                    </span>
                    <span class="text-gray-400 text-[9px] md:text-xs">/pax</span>
                </div>
                <div class="bg-amber-500 text-white text-[9px] md:text-xs px-2.5 py-1 rounded-full font-medium group-hover:bg-amber-600 transition">
                    Lihat
                </div>
            </div>
        </div>
    </div>
</a>

@once
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
@endonce