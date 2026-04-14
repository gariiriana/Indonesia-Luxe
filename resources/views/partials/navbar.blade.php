<nav x-data="{ menuOpen: false, profileOpen: false }" class="bg-white sticky top-0 z-50 transition-shadow duration-300" id="main-navbar">
    {{-- Shadow applied on scroll via JS --}}
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">

            {{-- Left: Hamburger + Logo --}}
            <div class="flex items-center gap-2">
                <button @click="menuOpen = !menuOpen" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                    <i x-show="!menuOpen" data-lucide="menu" class="w-6 h-6 text-gray-700"></i>
                    <i x-show="menuOpen" data-lucide="x" class="w-6 h-6 text-gray-700" x-cloak></i>
                </button>
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-full bg-amber-500 flex items-center justify-center shadow-sm">
                        <span class="text-white text-sm font-serif font-bold">IL</span>
                    </div>
                    <span class="hidden sm:block font-serif font-semibold text-gray-800 tracking-widest text-sm"
                          style="letter-spacing: 0.12em;">INDONESIA LUXE</span>
                </a>
            </div>

            {{-- Center: Desktop Nav Links --}}
            <div class="hidden md:flex items-center gap-1" x-data="{ catOpen: false }">
                <a href="{{ route('home') }}"
                   class="px-4 py-2 text-gray-600 hover:text-amber-600 rounded-lg hover:bg-amber-50 transition text-sm font-medium {{ request()->routeIs('home') ? 'text-amber-600 bg-amber-50' : '' }}">
                    Beranda
                </a>
                <div class="relative" @mouseenter="catOpen=true" @mouseleave="catOpen=false">
                    <button class="flex items-center gap-1.5 px-4 py-2 text-gray-600 hover:text-amber-600 rounded-lg hover:bg-amber-50 transition text-sm font-medium">
                        Kategori <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform" :class="catOpen ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="catOpen" x-transition x-cloak
                         class="absolute left-0 top-full mt-1 bg-white shadow-xl rounded-2xl py-2 min-w-[220px] border border-gray-100 z-50">
                        @php
                        $catIcons2 = ['Open Trip'=>'users','Private Tour'=>'compass','Hiking / Camping'=>'tent','Rafting'=>'waves','Snorkeling / Diving'=>'ship','Jeep Adventure'=>'car','Local Experience'=>'heart'];
                        @endphp
                        @foreach(['Open Trip', 'Private Tour', 'Hiking / Camping', 'Rafting', 'Snorkeling / Diving', 'Jeep Adventure', 'Local Experience'] as $cat)
                        <a href="{{ route('search', ['category' => $cat]) }}"
                           class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition">
                            <i data-lucide="{{ $catIcons2[$cat] ?? 'map' }}" class="w-4 h-4 text-amber-400"></i>
                            {{ $cat }}
                        </a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('search') }}"
                   class="px-4 py-2 text-gray-600 hover:text-amber-600 rounded-lg hover:bg-amber-50 transition text-sm font-medium">
                    Semua Tour
                </a>
            </div>

            {{-- Right: Cart + Auth --}}
            <div class="flex items-center gap-1.5">
                {{-- Cart Button --}}
                <a href="{{ route('cart') }}" class="relative p-2.5 hover:bg-amber-50 rounded-full transition">
                    <i data-lucide="shopping-cart" class="w-5 h-5 text-gray-600"></i>
                    @auth
                        @php $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity'); @endphp
                        @if($cartCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 bg-amber-500 text-white text-xs rounded-full w-4.5 h-4.5 flex items-center justify-center font-bold" style="width:18px;height:18px;font-size:10px;">
                            {{ $cartCount > 9 ? '9+' : $cartCount }}
                        </span>
                        @endif
                    @endauth
                </a>

                {{-- Auth Section --}}
                @auth
                    <div class="relative" x-data="{ open: false }" @click.away="open=false">
                        <button @click="open=!open"
                                class="flex items-center gap-2 pl-2 pr-3 py-1.5 hover:bg-amber-50 rounded-full transition">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt=""
                                     class="w-8 h-8 rounded-full object-cover border-2 border-amber-200">
                            @else
                                <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="hidden md:inline text-sm text-gray-700 font-medium">{{ explode(' ', auth()->user()->name)[0] }}</span>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-gray-400 hidden md:inline transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" x-transition x-cloak
                             class="absolute right-0 top-full mt-2 bg-white shadow-2xl rounded-2xl py-2 min-w-[210px] z-50 border border-gray-100">
                            {{-- User info header --}}
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate mt-0.5">{{ auth()->user()->email }}</p>
                                <span class="inline-block mt-1.5 text-xs bg-amber-100 text-amber-700 px-2.5 py-0.5 rounded-full capitalize font-medium">
                                    {{ auth()->user()->role }}
                                </span>
                            </div>
                            {{-- Role-based links --}}
                            @if(auth()->user()->role === 'user')
                                <a href="{{ route('profile.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 hover:bg-amber-50 text-gray-700 text-sm transition">
                                    <i data-lucide="user" class="w-4 h-4 text-gray-400"></i> Profil Saya
                                </a>
                                <a href="{{ route('bookings') }}" class="flex items-center gap-2.5 px-4 py-2.5 hover:bg-amber-50 text-gray-700 text-sm transition">
                                    <i data-lucide="package" class="w-4 h-4 text-gray-400"></i> Pesanan Saya
                                </a>
                                <a href="{{ route('cart') }}" class="flex items-center gap-2.5 px-4 py-2.5 hover:bg-amber-50 text-gray-700 text-sm transition">
                                    <i data-lucide="shopping-cart" class="w-4 h-4 text-gray-400"></i> Keranjang
                                </a>
                            @elseif(auth()->user()->role === 'vendor')
                                <a href="{{ route('vendor.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 hover:bg-amber-50 text-gray-700 text-sm transition">
                                    <i data-lucide="layout-dashboard" class="w-4 h-4 text-gray-400"></i> Vendor Dashboard
                                </a>
                            @elseif(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 hover:bg-amber-50 text-gray-700 text-sm transition">
                                    <i data-lucide="layout-dashboard" class="w-4 h-4 text-gray-400"></i> Admin Dashboard
                                </a>
                            @endif
                            <div class="border-t border-gray-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2.5 px-4 py-2.5 hover:bg-red-50 text-red-500 w-full text-left text-sm transition">
                                        <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="hidden md:flex items-center gap-2">
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 text-amber-600 border border-amber-500 rounded-lg hover:bg-amber-50 transition text-sm font-medium">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition text-sm font-semibold shadow-sm">
                            Daftar
                        </a>
                    </div>
                    <a href="{{ route('login') }}" class="md:hidden p-2.5 hover:bg-amber-50 rounded-full transition">
                        <i data-lucide="user" class="w-5 h-5 text-gray-600"></i>
                    </a>
                @endauth
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="menuOpen" x-cloak x-transition class="md:hidden fixed inset-0 top-16 bg-white z-40 overflow-y-auto shadow-xl">
        <div class="px-4 py-4 space-y-1">
            @auth
                <div class="flex items-center gap-3 pb-4 mb-4 border-b border-gray-100">
                    <div class="w-11 h-11 bg-amber-500 rounded-full flex items-center justify-center text-white font-semibold text-lg">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-gray-900 font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            @endauth

            <a href="{{ route('home') }}" @click="menuOpen=false" class="flex items-center gap-3 py-3 text-gray-700 border-b border-gray-50 text-sm font-medium">
                <i data-lucide="home" class="w-4 h-4 text-gray-400"></i> Beranda
            </a>
            <a href="{{ route('search') }}" @click="menuOpen=false" class="flex items-center gap-3 py-3 text-gray-700 border-b border-gray-50 text-sm font-medium">
                <i data-lucide="search" class="w-4 h-4 text-gray-400"></i> Semua Tour
            </a>

            <p class="text-xs text-gray-400 uppercase tracking-wider pt-4 pb-2 px-1">Kategori</p>
            @foreach(['Open Trip', 'Private Tour', 'Hiking / Camping', 'Rafting', 'Snorkeling / Diving', 'Jeep Adventure', 'Local Experience'] as $cat)
            <a href="{{ route('search', ['category' => $cat]) }}" @click="menuOpen=false"
               class="block py-2.5 pl-4 text-gray-600 hover:text-amber-600 transition text-sm border-b border-gray-50">
                {{ $cat }}
            </a>
            @endforeach

            @guest
                <div class="border-t border-gray-100 pt-4 mt-4 space-y-3">
                    <a href="{{ route('login') }}"
                       class="block w-full text-center py-3 text-amber-600 border-2 border-amber-500 rounded-xl hover:bg-amber-50 transition font-semibold">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="block w-full text-center py-3 bg-amber-500 text-white rounded-xl hover:bg-amber-600 transition font-semibold">
                        Daftar Gratis
                    </a>
                </div>
            @endguest

            @auth
                <div class="border-t border-gray-100 pt-4 mt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 py-2 text-red-500 text-sm w-full">
                            <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>

@push('scripts')
<script>
    // Add shadow on scroll
    window.addEventListener('scroll', function() {
        const nav = document.getElementById('main-navbar');
        if (window.scrollY > 10) {
            nav.classList.add('shadow-md');
        } else {
            nav.classList.remove('shadow-md');
        }
    });
</script>
@endpush