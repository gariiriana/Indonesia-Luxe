<nav x-data="{ menuOpen: false, profileOpen: false, searchOpen: false }" class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">

            {{-- Left: Hamburger + Logo --}}
            <div class="flex items-center gap-1">
                <button @click="menuOpen = !menuOpen" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                    <i x-show="!menuOpen" data-lucide="menu" class="w-6 h-6"></i>
                    <i x-show="menuOpen" data-lucide="x" class="w-6 h-6" x-cloak></i>
                </button>
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center">
                        <span class="text-white text-lg font-serif font-bold">IL</span>
                    </div>
                    <span class="hidden sm:block tracking-widest text-amber-700 font-serif"
                        style="font-size:1.05rem; letter-spacing:0.15em">INDONESIA LUXE</span>
                </a>
            </div>

            {{-- Center: Desktop Nav Links --}}
            <div class="hidden md:flex items-center gap-1" x-data="{ catOpen: false }">
                <a href="{{ route('home') }}"
                    class="px-4 py-2 text-gray-700 hover:text-amber-600 rounded-lg hover:bg-amber-50 transition text-sm">
                    Beranda
                </a>
                <div class="relative" @mouseenter="catOpen=true" @mouseleave="catOpen=false">
                    <button
                        class="flex items-center gap-1 px-4 py-2 text-gray-700 hover:text-amber-600 rounded-lg hover:bg-amber-50 transition text-sm">
                        Kategori <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </button>
                    <div x-show="catOpen" x-transition x-cloak
                        class="absolute left-0 top-full mt-1 bg-white shadow-xl rounded-xl py-2 min-w-[220px] border border-gray-100 z-50">
                        @foreach(['Open Trip', 'Private Tour', 'Hiking / Camping', 'Rafting', 'Snorkeling / Diving', 'Jeep Adventure', 'Local Experience'] as $cat)
                            <a href="{{ route('search', ['category' => $cat]) }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition">
                                {{ $cat }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('search') }}"
                    class="px-4 py-2 text-gray-700 hover:text-amber-600 rounded-lg hover:bg-amber-50 transition text-sm">
                    Semua Tour
                </a>
            </div>

            {{-- Right: Cart + Auth --}}
            <div class="flex items-center gap-2">
                {{-- Cart --}}
                <a href="{{ route('cart') }}" class="relative p-2 hover:bg-amber-50 rounded-full transition">
                    <i data-lucide="shopping-cart" class="w-5 h-5 text-gray-700"></i>
                    @auth
                        @php $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity'); @endphp
                        @if($cartCount > 0)
                            <span
                                class="absolute -top-1 -right-1 bg-amber-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    @endauth
                </a>

                {{-- Profile / Auth --}}
                @auth
                    <div class="relative" x-data="{ open: false }" @click.away="open=false">
                        <button @click="open=!open"
                            class="flex items-center gap-2 p-1.5 hover:bg-amber-50 rounded-lg transition">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt=""
                                    class="w-8 h-8 rounded-full object-cover border border-amber-200">
                            @else
                                <div
                                    class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="hidden md:inline text-sm text-gray-700">{{ auth()->user()->name }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 hidden md:inline"></i>
                        </button>
                        <div x-show="open" x-transition x-cloak
                            class="absolute right-0 top-full mt-1.5 bg-white shadow-xl rounded-xl py-2 min-w-[200px] z-50 border border-gray-100">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                <span
                                    class="inline-block mt-1 text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full capitalize">
                                    {{ auth()->user()->role }}
                                </span>
                            </div>
                            @if(auth()->user()->role === 'user')
                                <a href="{{ route('profile.index') }}"
                                    class="flex items-center gap-2 px-4 py-2 hover:bg-amber-50 text-gray-700 text-sm transition">
                                    <i data-lucide="user" class="w-4 h-4"></i> Profil Saya
                                </a>
                                <a href="{{ route('bookings') }}"
                                    class="flex items-center gap-2 px-4 py-2 hover:bg-amber-50 text-gray-700 text-sm transition">
                                    <i data-lucide="package" class="w-4 h-4"></i> Pesanan Saya
                                </a>
                            @elseif(auth()->user()->role === 'vendor')
                                <a href="{{ route('vendor.dashboard') }}"
                                    class="flex items-center gap-2 px-4 py-2 hover:bg-amber-50 text-gray-700 text-sm transition">
                                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Vendor Dashboard
                                </a>
                            @elseif(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}"
                                    class="flex items-center gap-2 px-4 py-2 hover:bg-amber-50 text-gray-700 text-sm transition">
                                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Admin Dashboard
                                </a>
                            @endif
                            <div class="border-t border-gray-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-2 px-4 py-2 hover:bg-red-50 text-red-600 w-full text-left text-sm transition">
                                        <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="hidden md:flex items-center gap-2">
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-amber-600 border border-amber-600 rounded-lg hover:bg-amber-50 transition text-sm">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition text-sm">
                            Daftar
                        </a>
                    </div>
                    <a href="{{ route('login') }}" class="md:hidden p-2 hover:bg-amber-50 rounded-full transition">
                        <i data-lucide="user" class="w-5 h-5 text-gray-700"></i>
                    </a>
                @endauth
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="menuOpen" x-cloak x-transition class="md:hidden fixed inset-0 top-16 bg-white z-40 overflow-y-auto">
        <div class="px-4 py-4 space-y-1">
            @auth
                <div class="flex items-center gap-3 pb-4 mb-4 border-b border-gray-100">
                    <div
                        class="w-11 h-11 bg-amber-500 rounded-full flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-gray-900 font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            @endauth

            <a href="{{ route('home') }}" @click="menuOpen=false"
                class="block py-3 text-gray-700 border-b border-gray-50">Beranda</a>

            <p class="text-xs text-gray-400 uppercase tracking-wider pt-3 pb-1">Kategori</p>
            @foreach(['Open Trip', 'Private Tour', 'Hiking / Camping', 'Rafting', 'Snorkeling / Diving', 'Jeep Adventure', 'Local Experience'] as $cat)
                <a href="{{ route('search', ['category' => $cat]) }}" @click="menuOpen=false"
                    class="block py-2.5 pl-4 text-gray-600 hover:text-amber-600 transition text-sm">
                    {{ $cat }}
                </a>
            @endforeach

            @guest
                <div class="border-t border-gray-100 pt-4 mt-4 space-y-2">
                    <a href="{{ route('login') }}"
                        class="block w-full text-center py-2.5 text-amber-600 border border-amber-600 rounded-xl hover:bg-amber-50 transition">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="block w-full text-center py-2.5 bg-amber-500 text-white rounded-xl hover:bg-amber-600 transition">Daftar</a>
                </div>
            @endguest

            @auth
                <div class="border-t border-gray-100 pt-4 mt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 py-2 text-red-600 text-sm w-full">
                            <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>