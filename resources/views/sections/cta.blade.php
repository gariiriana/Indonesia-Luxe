<!-- CTA Section -->
<section class="py-20 lg:py-28 relative overflow-hidden">
    <!-- Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-primary-500 via-accent-500 to-secondary-500"></div>
    
    <!-- Animated Pattern -->
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); animation: patternMove 20s linear infinite;"></div>

    <!-- Floating Shapes -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-10 w-32 h-32 bg-white/10 rounded-full animate-float" style="animation-delay: 0s; animation-duration: 8s;"></div>
        <div class="absolute bottom-20 right-20 w-24 h-24 bg-white/10 rounded-full animate-float" style="animation-delay: 2s; animation-duration: 10s;"></div>
        <div class="absolute top-1/2 right-1/4 w-16 h-16 bg-white/10 rotate-45 animate-float" style="animation-delay: 4s; animation-duration: 12s;"></div>
    </div>

    <div class="w-full px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Headline -->
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                Siap Memulai Petualangan Anda?
            </h2>

            <!-- Subheadline -->
            <p class="text-white/90 text-lg sm:text-xl mb-10 max-w-2xl mx-auto">
                Dapatkan diskon 20% untuk pemesanan pertama. 
                Jelajahi keindahan Indonesia bersama kami!
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-10">
                <a 
                    href="{{ route('search') }}"
                    class="bg-white text-primary-600 hover:bg-gray-100 px-8 py-4 text-lg font-semibold rounded-xl shadow-xl hover:shadow-2xl transition-all hover:-translate-y-1 inline-flex items-center justify-center gap-2 group"
                >
                    Pesan Sekarang
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a 
                    href="#"
                    class="border-2 border-white text-white hover:bg-white/10 px-8 py-4 text-lg font-semibold rounded-xl transition-all inline-flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Hubungi Kami
                </a>
            </div>

            <!-- Trust Badges -->
            <div class="flex flex-wrap justify-center gap-6">
                @php
                    $badges = [
                        'Pembayaran Aman',
                        'Bisa Dibatalkan',
                        'Guide Profesional',
                    ];
                @endphp

                @foreach($badges as $badge)
                    <div class="flex items-center gap-2 text-white/90">
                        <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium">{{ $badge }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        @keyframes patternMove {
            0% { background-position: 0 0; }
            100% { background-position: 60px 60px; }
        }
    </style>
</section>
