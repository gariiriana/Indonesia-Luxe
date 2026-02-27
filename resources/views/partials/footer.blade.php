<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center">
                        <span class="text-white text-lg font-serif font-bold">IL</span>
                    </div>
                    <span class="tracking-widest text-amber-400 font-serif"
                        style="font-size:1rem; letter-spacing:0.15em">INDONESIA LUXE</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Platform tour & travel premium terpercaya di Indonesia. Temukan pengalaman tak terlupakan bersama
                    kami.
                </p>
                <div class="flex gap-3 mt-4">
                    <a href="https://instagram.com" target="_blank"
                        class="text-gray-400 hover:text-amber-400 transition">
                        <i data-lucide="instagram" class="w-5 h-5"></i>
                    </a>
                    <a href="https://facebook.com" target="_blank"
                        class="text-gray-400 hover:text-amber-400 transition">
                        <i data-lucide="facebook" class="w-5 h-5"></i>
                    </a>
                    <a href="https://wa.me/6287711172386" target="_blank"
                        class="text-gray-400 hover:text-green-400 transition">
                        <i data-lucide="message-circle" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>

            {{-- Aktivitas --}}
            <div>
                <h3 class="text-amber-400 mb-4 font-semibold">Aktivitas</h3>
                <div class="space-y-2">
                    @foreach(['Open Trip', 'Private Tour', 'Hiking / Camping', 'Rafting', 'Snorkeling / Diving', 'Jeep Adventure', 'Local Experience'] as $cat)
                        <a href="{{ route('search', ['category' => $cat]) }}"
                            class="block text-gray-400 hover:text-amber-400 text-sm transition">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Informasi --}}
            <div>
                <h3 class="text-amber-400 mb-4 font-semibold">Informasi</h3>
                <div class="space-y-2">
                    <a href="{{ route('search') }}"
                        class="block text-gray-400 hover:text-amber-400 text-sm transition">Cari Tour</a>
                    <a href="{{ route('login') }}"
                        class="block text-gray-400 hover:text-amber-400 text-sm transition">Login Akun</a>
                    <a href="{{ route('register') }}"
                        class="block text-gray-400 hover:text-amber-400 text-sm transition">Daftar jadi Vendor</a>
                    @auth
                        <a href="{{ route('profile.promo-codes') }}"
                            class="block text-gray-400 hover:text-amber-400 text-sm transition">Kode Promo</a>
                        <a href="{{ route('profile.luxe-points') }}"
                            class="block text-gray-400 hover:text-amber-400 text-sm transition">Luxe Points</a>
                    @endauth
                </div>
            </div>

            {{-- Kontak --}}
            <div>
                <h3 class="text-amber-400 mb-4 font-semibold">Hubungi Kami</h3>
                <div class="space-y-3">
                    <a href="https://wa.me/6287711172386" target="_blank"
                        class="flex items-center gap-2 text-gray-400 hover:text-green-400 text-sm transition">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        +62 877-1117-2386
                    </a>
                    <div class="flex items-center gap-2 text-gray-400 text-sm">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                        info@indonesialuxe.com
                    </div>
                    <div class="flex items-center gap-2 text-gray-400 text-sm">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                        Jakarta, Indonesia
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-10 pt-8 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Indonesia Luxe. All rights reserved.
        </div>
    </div>
</footer>