@extends('layouts.app')

@section('title', 'Cari Paket Tour - Indonesia Luxe')
@section('description', 'Temukan ribuan paket tour terbaik di Indonesia. Filter berdasarkan kategori, harga, dan destinasi.')

@section('content')

{{-- Page Header --}}
<div class="bg-gradient-to-r from-amber-500 to-amber-600 py-10">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-white text-2xl md:text-3xl font-serif mb-2">
            @if(request('category'))
                {{ request('category') }}
            @elseif(request('q'))
                Hasil Pencarian: "{{ request('q') }}"
            @else
                Semua Paket Tour
            @endif
        </h1>
        <p class="text-amber-100 text-sm">{{ $packages->total() }} paket tersedia</p>

        {{-- Search Bar --}}
        <form action="{{ route('search') }}" method="GET" class="mt-5">
            @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
            @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
            <div class="flex bg-white rounded-xl overflow-hidden shadow-lg max-w-2xl">
                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="Cari destinasi, aktivitas, atau nama tour..."
                       class="flex-1 px-5 py-3.5 outline-none text-gray-700 text-sm placeholder-gray-400">
                <button type="submit" class="px-6 py-3.5 bg-amber-500 hover:bg-amber-600 text-white transition flex items-center gap-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    <span class="hidden sm:inline text-sm font-medium">Cari</span>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-6">

        {{-- ── Filter Sidebar ── --}}
        <aside class="lg:w-72 shrink-0">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sticky top-20">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="sliders-horizontal" class="w-4 h-4 text-amber-500"></i>
                        Filter
                    </h2>
                    <a href="{{ route('search') }}" class="text-xs text-amber-600 hover:text-amber-700 font-medium hover:underline">Reset Semua</a>
                </div>

                <form action="{{ route('search') }}" method="GET">
                    @if(request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                    @endif

                    {{-- Category --}}
                    <div class="mb-5">
                        <label class="text-sm font-semibold text-gray-700 mb-3 block">Kategori</label>
                        <div class="space-y-1.5">
                            <label class="flex items-center gap-2.5 py-1.5 cursor-pointer hover:text-amber-600 transition">
                                <input type="radio" name="category" value=""
                                       {{ !request('category') ? 'checked' : '' }}
                                       class="text-amber-500 focus:ring-amber-500">
                                <span class="text-sm text-gray-600">Semua Kategori</span>
                            </label>
                            @foreach($categories as $cat)
                            <label class="flex items-center gap-2.5 py-1.5 cursor-pointer hover:text-amber-600 transition">
                                <input type="radio" name="category" value="{{ $cat->name }}"
                                       {{ request('category') === $cat->name ? 'checked' : '' }}
                                       class="text-amber-500 focus:ring-amber-500">
                                <span class="text-sm text-gray-600">{{ $cat->name }}</span>
                                @if($cat->packages_count)
                                <span class="ml-auto text-xs text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded-full">{{ $cat->packages_count }}</span>
                                @endif
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <hr class="my-4 border-gray-100">

                    {{-- Price Range --}}
                    <div class="mb-5">
                        <label class="text-sm font-semibold text-gray-700 mb-3 block">Rentang Harga</label>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="text-xs text-gray-400 mb-1 block">Min</label>
                                <input type="number" name="min_price" placeholder="0"
                                       value="{{ request('min_price') }}"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 mb-1 block">Max</label>
                                <input type="number" name="max_price" placeholder="10.000.000"
                                       value="{{ request('max_price') }}"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                            </div>
                        </div>
                        {{-- Quick price filters --}}
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            @foreach([['0', '500000', '< 500rb'], ['500000', '1500000', '500rb-1,5jt'], ['1500000', '', '> 1,5jt']] as $p)
                            <a href="{{ route('search', array_merge(request()->except(['min_price','max_price']), ['min_price'=>$p[0],'max_price'=>$p[1]])) }}"
                               class="text-xs px-2 py-1 border border-gray-200 rounded-full hover:border-amber-400 hover:text-amber-600 transition {{ request('min_price')==$p[0] && request('max_price')==$p[1] ? 'border-amber-400 text-amber-600 bg-amber-50' : 'text-gray-500' }}">
                                {{ $p[2] }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <hr class="my-4 border-gray-100">

                    {{-- Sort --}}
                    <div class="mb-5">
                        <label class="text-sm font-semibold text-gray-700 mb-3 block">Urutkan</label>
                        <select name="sort" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                            <option value="">Relevansi</option>
                            <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                            <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Terpopuler</option>
                            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        </select>
                    </div>

                    <button type="submit"
                            class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-xl font-semibold transition shadow-sm shadow-amber-200 flex items-center justify-center gap-2">
                        <i data-lucide="filter" class="w-4 h-4"></i>
                        Terapkan Filter
                    </button>
                </form>
            </div>
        </aside>

        {{-- ── Results ── --}}
        <div class="flex-1">
            {{-- Active filters display --}}
            @if(request()->anyFilled(['category', 'min_price', 'max_price', 'sort']))
            <div class="flex flex-wrap items-center gap-2 mb-4">
                <span class="text-sm text-gray-500">Filter aktif:</span>
                @if(request('category'))
                <a href="{{ route('search', request()->except('category')) }}"
                   class="flex items-center gap-1.5 text-xs bg-amber-100 text-amber-700 px-3 py-1.5 rounded-full hover:bg-amber-200 transition">
                    {{ request('category') }} <i data-lucide="x" class="w-3 h-3"></i>
                </a>
                @endif
                @if(request('min_price') || request('max_price'))
                <a href="{{ route('search', request()->except(['min_price','max_price'])) }}"
                   class="flex items-center gap-1.5 text-xs bg-amber-100 text-amber-700 px-3 py-1.5 rounded-full hover:bg-amber-200 transition">
                    Harga <i data-lucide="x" class="w-3 h-3"></i>
                </a>
                @endif
            </div>
            @endif

            {{-- Results count --}}
            <div class="flex items-center justify-between mb-5">
                <p class="text-gray-500 text-sm">
                    Menampilkan <strong class="text-gray-900">{{ $packages->total() }}</strong> paket
                    @if(request('q')) untuk "<strong class="text-amber-600">{{ request('q') }}</strong>" @endif
                </p>
            </div>

            @if($packages->isEmpty())
            <div class="text-center py-20 bg-white rounded-2xl border border-dashed border-gray-200">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="search-x" class="w-9 h-9 text-gray-300"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Paket tidak ditemukan</h3>
                <p class="text-gray-400 text-sm mb-5">Coba ubah kata kunci atau hapus beberapa filter</p>
                <a href="{{ route('search') }}"
                   class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-6 py-2.5 rounded-full transition font-medium text-sm">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    Reset Pencarian
                </a>
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
