<nav 
    x-data="{ 
        isScrolled: false,
        mobileOpen: false,
        searchOpen: false,
        searchQuery: ''
    }"
    x-init="window.addEventListener('scroll', () => isScrolled = window.scrollY > 50)"
    :class="isScrolled ? 'bg-white/95 backdrop-blur-md shadow-lg' : 'bg-transparent'"
    class="fixed top-0 left-0 right-0 z-40 transition-all duration-300"
>
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-10 h-10 lg:w-12 lg:h-12 gradient-bg rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 lg:w-7 lg:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span :class="isScrolled ? 'text-dark' : 'text-white'" class="text-xl lg:text-2xl font-bold transition-colors">
                    Indonesia<span class="text-primary-500">Luxe</span>
                </span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center gap-8">
                <a href="#categories" :class="isScrolled ? 'text-gray-700 hover:text-primary-500' : 'text-white/90 hover:text-white'" class="font-medium transition-colors">Kategori</a>
                <a href="#destinations" :class="isScrolled ? 'text-gray-700 hover:text-primary-500' : 'text-white/90 hover:text-white'" class="font-medium transition-colors">Destinasi</a>
                <a href="#packages" :class="isScrolled ? 'text-gray-700 hover:text-primary-500' : 'text-white/90 hover:text-white'" class="font-medium transition-colors">Paket</a>
                <a href="{{ route('search') }}" :class="isScrolled ? 'text-gray-700 hover:text-primary-500' : 'text-white/90 hover:text-white'" class="font-medium transition-colors">Cari</a>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-2 lg:gap-4">
                <!-- Search Toggle -->
                <button 
                    @click="searchOpen = !searchOpen"
                    :class="isScrolled ? 'text-gray-700 hover:bg-gray-100' : 'text-white hover:bg-white/10'"
                    class="p-2 rounded-lg transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>

                <!-- Cart -->
                <button 
                    @click="cartOpen = true"
                    :class="isScrolled ? 'text-gray-700 hover:bg-gray-100' : 'text-white hover:bg-white/10'"
                    class="p-2 rounded-lg transition-colors relative"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    @if(session()->has('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-secondary-500 text-white text-xs rounded-full flex items-center justify-center font-bold animate-bounce">
                            {{ collect(session('cart'))->sum('travelers') }}
                        </span>
                    @endif
                </button>

                <!-- Auth -->
                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-400 to-accent-500 flex items-center justify-center text-white font-semibold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </button>
                        <div 
                            x-show="open" 
                            @click.away="open = false"
                            x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2"
                        >
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Profil</a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Pesanan Saya</a>
                            @if(auth()->user()->isVendor())
                                <a href="{{ route('vendor.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Vendor Dashboard</a>
                            @endif
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Admin Panel</a>
                            @endif
                            <hr class="my-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a 
                        href="{{ route('login') }}"
                        :class="isScrolled ? 'bg-primary-500 text-white hover:bg-primary-600' : 'bg-white text-primary-600 hover:bg-gray-100'"
                        class="hidden sm:block px-5 py-2 rounded-full font-medium transition-colors"
                    >
                        Login
                    </a>
                @endauth

                <!-- Mobile Menu Toggle -->
                <button 
                    @click="mobileOpen = !mobileOpen"
                    :class="isScrolled ? 'text-gray-700' : 'text-white'"
                    class="lg:hidden p-2"
                >
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Search Bar -->
        <div 
            x-show="searchOpen" 
            x-transition
            class="pb-4"
        >
            <form action="{{ route('search') }}" method="GET" class="flex gap-2">
                <input 
                    type="text" 
                    name="search" 
                    x-model="searchQuery"
                    placeholder="Cari destinasi, paket wisata..."
                    class="flex-1 px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-primary-500"
                    :class="isScrolled ? 'bg-gray-100' : 'bg-white/20 text-white placeholder-white/70'"
                >
                <button type="submit" class="px-6 py-3 gradient-bg text-white rounded-xl font-medium hover:opacity-90 transition-opacity">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div 
        x-show="mobileOpen" 
        x-transition
        class="lg:hidden bg-white border-t shadow-lg"
    >
        <div class="px-4 py-4 space-y-2">
            <a href="#categories" class="block px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg font-medium">Kategori</a>
            <a href="#destinations" class="block px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg font-medium">Destinasi</a>
            <a href="#packages" class="block px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg font-medium">Paket Wisata</a>
            <a href="{{ route('search') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg font-medium">Cari</a>
            @guest
                <a href="{{ route('login') }}" class="block px-4 py-3 text-primary-600 font-medium">Login</a>
            @endguest
        </div>
    </div>
</nav>
