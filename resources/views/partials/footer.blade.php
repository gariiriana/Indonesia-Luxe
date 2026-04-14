<footer class="bg-gray-900 text-white">
    {{-- Top CTA Bar --}}
    <div class="border-b border-gray-800" style="background: linear-gradient(135deg, #1a1a2e, #16213e);">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div>
                    <h3 class="text-xl font-serif text-white mb-1">Siap Memulai Petualangan?</h3>
                    <p class="text-gray-400 text-sm">Bergabunglah dengan 10.000+ wisatawan yang telah mempercayai kami</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('search') }}" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg font-semibold transition text-sm">
                        Cari Paket Tour
                    </a>
                    @guest
                    <a href="{{ route('register') }}" class="px-6 py-2.5 border border-gray-600 hover:border-amber-400 text-gray-300 hover:text-amber-400 rounded-lg transition text-sm">
                        Daftar Gratis
                    </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    {{-- Main Footer --}}
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 lg:gap-12">

            {{-- Brand --}}
            <div class="md:col-span-1">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center shadow-lg">
                        <span class="text-white text-sm font-serif font-bold">IL</span>
                    </div>
                    <span class="tracking-widest text-amber-400 font-serif font-semibold"
                          style="font-size: 0.9rem; letter-spacing: 0.15em;">INDONESIA LUXE</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed mb-5">
                    Platform tour & travel premium terpercaya di Indonesia. Temukan pengalaman tak terlupakan dari Sabang sampai Merauke bersama kami.
                </p>
                {{-- Social Icons --}}
                <div class="flex gap-3">
                    <a href="https://instagram.com" target="_blank"
                       class="w-9 h-9 bg-gray-800 hover:bg-amber-500 rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition">
                        <i data-lucide="instagram" class="w-4 h-4"></i>
                    </a>
                    <a href="https://facebook.com" target="_blank"
                       class="w-9 h-9 bg-gray-800 hover:bg-amber-500 rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition">
                        <i data-lucide="facebook" class="w-4 h-4"></i>
                    </a>
                    <a href="https://wa.me/6287711172386" target="_blank"
                       class="w-9 h-9 bg-gray-800 hover:bg-green-600 rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                    </a>
                    <a href="https://twitter.com" target="_blank"
                       class="w-9 h-9 bg-gray-800 hover:bg-amber-500 rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition">
                        <i data-lucide="twitter" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

            {{-- Aktivitas --}}
            <div>
                <h3 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Aktivitas</h3>
                <div class="space-y-2.5">
                    @foreach(['Open Trip', 'Private Tour', 'Hiking / Camping', 'Rafting', 'Snorkeling / Diving', 'Jeep Adventure', 'Local Experience'] as $cat)
                    <a href="{{ route('search', ['category' => $cat]) }}"
                       class="block text-gray-400 hover:text-amber-400 text-sm transition flex items-center gap-2">
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5 opacity-0 group-hover:opacity-100"></i>
                        {{ $cat }}
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Informasi --}}
            <div>
                <h3 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Informasi</h3>
                <div class="space-y-2.5">
                    <a href="{{ route('search') }}" class="block text-gray-400 hover:text-amber-400 text-sm transition">Cari Tour</a>
                    <a href="{{ route('login') }}" class="block text-gray-400 hover:text-amber-400 text-sm transition">Login Akun</a>
                    <a href="{{ route('register') }}" class="block text-gray-400 hover:text-amber-400 text-sm transition">Daftar jadi Vendor</a>
                    @auth
                        <a href="{{ route('profile.promo-codes') }}" class="block text-gray-400 hover:text-amber-400 text-sm transition">Kode Promo</a>
                        <a href="{{ route('profile.luxe-points') }}" class="block text-gray-400 hover:text-amber-400 text-sm transition">Luxe Points</a>
                    @endauth
                    <a href="#" class="block text-gray-400 hover:text-amber-400 text-sm transition">FAQ</a>
                    <a href="#" class="block text-gray-400 hover:text-amber-400 text-sm transition">Kebijakan Privasi</a>
                </div>
            </div>

            {{-- Kontak --}}
            <div>
                <h3 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Hubungi Kami</h3>
                <div class="space-y-3">
                    <a href="https://wa.me/6287711172386" target="_blank"
                       class="flex items-center gap-3 text-gray-400 hover:text-green-400 text-sm transition group">
                        <div class="w-8 h-8 bg-gray-800 group-hover:bg-green-600/20 rounded-lg flex items-center justify-center transition">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                        </div>
                        +62 877-1117-2386
                    </a>
                    <div class="flex items-center gap-3 text-gray-400 text-sm">
                        <div class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                        info@indonesialuxe.com
                    </div>
                    <div class="flex items-center gap-3 text-gray-400 text-sm">
                        <div class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                        </div>
                        Jakarta, Indonesia
                    </div>
                    <div class="flex items-center gap-3 text-gray-400 text-sm">
                        <div class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                        </div>
                        Senin - Minggu, 08:00 - 22:00 WIB
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 py-5">
            <div class="flex flex-col md:flex-row items-center justify-between gap-3">
                <p class="text-gray-500 text-xs text-center md:text-left">
                    &copy; {{ date('Y') }} Indonesia Luxe. All rights reserved. Made with ❤️ in Indonesia.
                </p>
                <div class="flex items-center gap-4 text-xs text-gray-500">
                    <a href="#" class="hover:text-gray-300 transition">Terms of Service</a>
                    <span>·</span>
                    <a href="#" class="hover:text-gray-300 transition">Privacy Policy</a>
                    <span>·</span>
                    <a href="#" class="hover:text-gray-300 transition">Cookies</a>
                </div>
            </div>
        </div>
    </div>
</footer>