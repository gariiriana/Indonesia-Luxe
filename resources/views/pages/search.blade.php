@extends('layouts.app')

@section('title', 'Cari Paket Tour - Indonesia Luxe')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-6">

        {{-- ── Filter Sidebar ─────────────────────────────────────────────────── --}}
        <aside class="lg:w-72 shrink-0" x-data="{ filtersOpen: false }">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sticky top-20">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="font-semibold text-gray-900">Filter</h2>
                    <a href="{{ route('search') }}" class="text-xs text-amber-600 hover:underline">Reset</a>
                </div>

                <form action="{{ route('search') }}" method="GET">
                    @if(request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                    @endif

                    {{-- Category --}}
                    <div class="mb-5">
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Kategori</label>
                        @foreach($categories as $cat)
                        <label class="flex items-center gap-2 py-1.5 cursor-pointer">
                            <input type="radio" name="category" value="{{ $cat->name }}"
                                   {{ request('category') === $cat->name ? 'checked' : '' }}
                                   class="text-amber-500 focus:ring-amber-500">
                            <span class="text-sm text-gray-700">{{ $cat->name }}</span>
                        </label>
                        @endforeach
                    </div>

                    <hr class="my-4">

                    {{-- Price Range --}}
                    <div class="mb-5">
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Rentang Harga</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="min_price" placeholder="Min"
                                   value="{{ request('min_price') }}"
                                   class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-amber-500 focus:border-amber-500">
                            <input type="number" name="max_price" placeholder="Max"
                                   value="{{ request('max_price') }}"
                                   class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-amber-500 focus:border-amber-500">
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Sort --}}
                    <div class="mb-5">
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Urutkan</label>
                        <select name="sort" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-amber-500 focus:border-amber-500">
                            <option value="">Relevansi</option>
                            <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                            <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Terpopuler</option>
                            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white py-2.5 rounded-xl font-medium transition">
                        Terapkan Filter
                    </button>
                </form>
            </div>
        </aside>

        {{-- ── Results ────────────────────────────────────────────────────────── --}}
        <div class="flex-1">
            {{-- Search Bar --}}
            <form action="{{ route('search') }}" method="GET" class="mb-6">
                @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                <div class="flex bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Cari destinasi, aktivitas, atau nama tour..."
                           class="flex-1 px-5 py-3.5 outline-none text-gray-700 placeholder-gray-400">
                    <button type="submit" class="px-6 py-3.5 bg-amber-500 hover:bg-amber-600 text-white transition flex items-center gap-2">
                        <i data-lucide="search" class="w-5 h-5"></i>
                        <span class="hidden sm:inline">Cari</span>
                    </button>
                </div>
            </form>

            {{-- Results header --}}
            <div class="flex items-center justify-between mb-4">
                <p class="text-gray-600 text-sm">
                    Menampilkan <strong>{{ $packages->total() }}</strong> paket
                    @if(request('q')) untuk "<strong>{{ request('q') }}</strong>" @endif
                    @if(request('category')) dalam <strong>{{ request('category') }}</strong> @endif
                </p>
            </div>

            @if($packages->isEmpty())
            <div class="text-center py-20">
                <i data-lucide="search-x" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                <h3 class="text-xl text-gray-500 mb-2">Tidak ada paket ditemukan</h3>
                <p class="text-gray-400">Coba ubah kata kunci atau filter pencarian</p>
                <a href="{{ route('search') }}" class="mt-4 inline-block text-amber-600 hover:underline">Reset pencarian</a>
            </div>
            @else
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-5">
                @foreach($packages as $i => $package)
                <div data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 50 }}">
                    @include('components.tour-card', ['package' => $package])
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $packages->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
