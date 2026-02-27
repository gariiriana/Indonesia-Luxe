@extends('layouts.app')

@section('title', $package->title . ' - Indonesia Luxe')
@section('description', Str::limit($package->description, 160))

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- ── Left: Gallery + Details ─────────────────────────────────────────── --}}
            <div class="flex-1">

                {{-- Breadcrumb --}}
                <nav class="text-sm text-gray-500 mb-4 flex items-center gap-2">
                    <a href="{{ route('home') }}" class="hover:text-amber-600">Beranda</a>
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    <a href="{{ route('search', ['category' => $package->category->name]) }}"
                        class="hover:text-amber-600">{{ $package->category->name }}</a>
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    <span class="text-gray-700 truncate max-w-xs">{{ $package->title }}</span>
                </nav>

                {{-- Main Image --}}
                <div x-data="{ activeImg: '{{ $package->image }}' }" class="mb-6">
                    <div class="rounded-2xl overflow-hidden aspect-video bg-gray-100 mb-3">
                        <img :src="activeImg" alt="{{ $package->title }}" class="w-full h-full object-cover">
                    </div>
                    @if($package->gallery && count($package->gallery) > 1)
                        <div class="flex gap-2 overflow-x-auto pb-1">
                            @foreach($package->gallery as $img)
                                <button @click="activeImg='{{ $img }}'"
                                    class="shrink-0 w-20 h-16 rounded-xl overflow-hidden opacity-70 hover:opacity-100 transition">
                                    <img src="{{ $img }}" alt="" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Title & Rating --}}
                <h1 class="text-2xl md:text-3xl font-serif text-gray-900 mb-3">{{ $package->title }}</h1>
                <div class="flex items-center gap-4 mb-5 flex-wrap">
                    <div class="flex items-center gap-1 text-amber-500">
                        @for($s = 1; $s <= 5; $s++)
                            <i data-lucide="star"
                                class="w-5 h-5 {{ $s <= round($package->rating) ? 'fill-amber-500' : 'text-gray-300' }}"></i>
                        @endfor
                        <span class="text-gray-700 ml-1 font-medium">{{ $package->rating }}</span>
                        <span class="text-gray-400">({{ $package->review_count }} ulasan)</span>
                    </div>
                    <span class="flex items-center gap-1 text-gray-600 text-sm">
                        <i data-lucide="clock" class="w-4 h-4"></i> {{ $package->duration }}
                    </span>
                    <span
                        class="bg-amber-100 text-amber-700 text-xs px-3 py-1 rounded-full">{{ $package->category->name }}</span>
                </div>

                {{-- Tabs --}}
                <div x-data="{ tab: 'desc' }" class="mb-8">
                    <div class="flex gap-1 bg-gray-100 rounded-xl p-1 mb-5">
                        @foreach(['desc' => 'Deskripsi', 'inclusions' => 'Include', 'itinerary' => 'Itinerary', 'reviews' => 'Ulasan'] as $key => $label)
                            <button @click="tab='{{ $key }}'"
                                :class="tab==='{{ $key }}' ? 'bg-white shadow text-amber-600' : 'text-gray-600 hover:text-gray-900'"
                                class="flex-1 py-2 rounded-lg text-sm font-medium transition">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Description --}}
                    <div x-show="tab==='desc'">
                        <p class="text-gray-700 leading-relaxed">{{ $package->description }}</p>
                        @if($package->inclusions)
                            <h3 class="font-semibold text-gray-900 mt-6 mb-3">Yang Termasuk</h3>
                            <ul class="space-y-2">
                                @foreach($package->inclusions as $item)
                                    <li class="flex items-center gap-2 text-gray-700 text-sm">
                                        <i data-lucide="check-circle-2" class="w-4 h-4 text-green-500 shrink-0"></i> {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    {{-- Inclusions --}}
                    <div x-show="tab==='inclusions'" x-cloak>
                        @if($package->inclusions)
                            <ul class="space-y-3">
                                @foreach($package->inclusions as $item)
                                    <li class="flex items-center gap-3 p-3 bg-green-50 rounded-xl text-gray-700">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-green-500 shrink-0"></i> {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    {{-- Itinerary --}}
                    <div x-show="tab==='itinerary'" x-cloak>
                        @if($package->itinerary)
                            <div class="space-y-3">
                                @foreach($package->itinerary as $i => $item)
                                    <div class="flex gap-4">
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center text-sm font-semibold shrink-0">
                                                {{ $i + 1 }}
                                            </div>
                                            @if(!$loop->last)
                                                <div class="w-0.5 flex-1 bg-amber-200 my-1"></div>
                                            @endif
                                        </div>
                                        <p class="text-gray-700 pt-1.5">{{ $item }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Reviews --}}
                    <div x-show="tab==='reviews'" x-cloak>
                        @if($package->reviews && $package->reviews->count() > 0)
                            <div class="space-y-4">
                                @foreach($package->reviews->take(5) as $review)
                                    <div class="bg-gray-50 rounded-xl p-4">
                                        <div class="flex items-center gap-3 mb-2">
                                            <div
                                                class="w-9 h-9 bg-amber-500 rounded-full flex items-center justify-center text-white font-medium">
                                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 text-sm">{{ $review->user->name }}</p>
                                                <div class="flex gap-0.5">
                                                    @for($s = 1; $s <= 5; $s++)
                                                        <i data-lucide="star"
                                                            class="w-3.5 h-3.5 {{ $s <= $review->rating ? 'fill-amber-400 text-amber-400' : 'text-gray-300' }}"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <span
                                                class="ml-auto text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-700 text-sm">{{ $review->comment }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-400">
                                <i data-lucide="message-square" class="w-10 h-10 mx-auto mb-2 opacity-50"></i>
                                Belum ada ulasan untuk paket ini.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ── Right: Booking Card ─────────────────────────────────────────────── --}}
            <div class="lg:w-80 shrink-0">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-5 sticky top-20">
                    {{-- Price --}}
                    <div class="mb-4">
                        @if($package->original_price > $package->discounted_price)
                            <div class="text-gray-400 text-sm line-through">{{ $package->formatted_original_price }}</div>
                        @endif
                        <div class="text-3xl font-bold text-amber-600">{{ $package->formatted_price }}</div>
                        <div class="text-gray-500 text-sm">per orang</div>
                    </div>

                    @auth
                        <form action="{{ route('cart.store') }}" method="POST" class="space-y-3">
                            @csrf
                            <input type="hidden" name="package_id" value="{{ $package->id }}">
                            <div>
                                <label class="text-sm font-medium text-gray-700 mb-1 block">Jumlah Peserta</label>
                                <input type="number" name="quantity" value="1" min="1" max="20"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-amber-500 focus:border-amber-500">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-700 mb-1 block">Tanggal Keberangkatan</label>
                                <input type="date" name="travel_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-amber-500 focus:border-amber-500">
                            </div>
                            <button type="submit"
                                class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-xl font-semibold transition flex items-center justify-center gap-2">
                                <i data-lucide="shopping-cart" class="w-5 h-5"></i> Tambah ke Keranjang
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="block w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-xl font-semibold text-center transition">
                            Login untuk Pesan
                        </a>
                    @endauth

                    {{-- Info --}}
                    <div class="mt-4 pt-4 border-t border-gray-100 space-y-2">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i data-lucide="users" class="w-4 h-4 text-amber-500"></i>
                            <span>Max {{ $package->max_participants ?? 'Unlimited' }} peserta</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i data-lucide="shield-check" class="w-4 h-4 text-green-500"></i>
                            <span>Garansi uang kembali 24 jam</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i data-lucide="headphones" class="w-4 h-4 text-blue-500"></i>
                            <span>Support 24/7 via WhatsApp</span>
                        </div>
                    </div>
                </div>

                {{-- Related --}}
                @if($related->isNotEmpty())
                    <div class="mt-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Paket Serupa</h3>
                        <div class="space-y-3">
                            @foreach($related->take(3) as $rel)
                                <a href="{{ route('tour.show', $rel->slug) }}"
                                    class="flex items-center gap-3 bg-white rounded-xl p-3 hover:shadow-md transition border border-gray-100">
                                    <img src="{{ $rel->image }}" alt="{{ $rel->title }}"
                                        class="w-14 h-14 rounded-lg object-cover shrink-0">
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-900 line-clamp-2">{{ $rel->title }}</p>
                                        <p class="text-amber-600 text-sm font-semibold">{{ $rel->formatted_price }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection