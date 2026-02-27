<!-- Features Section -->
<section id="features" class="py-20 lg:py-28 bg-light relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary-200/30 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-accent-200/30 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

    <div class="w-full px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-dark mb-4">
                Mengapa Memilih <span class="gradient-text">Indonesia Luxe</span>?
            </h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Kami berkomitmen memberikan pengalaman wisata terbaik dengan layanan 
                berkualitas dan kepuasan pelanggan yang utama
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 max-w-6xl mx-auto">
            @php
                $features = [
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>',
                        'title' => 'Harga Terbaik',
                        'description' => 'Jaminan harga kompetitif untuk setiap paket perjalanan'
                    ],
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>',
                        'title' => 'Booking Mudah',
                        'description' => 'Proses pemesanan cepat dan aman dalam hitungan menit'
                    ],
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        'title' => 'Destinasi Lengkap',
                        'description' => 'Ribuan destinasi menarik di seluruh Indonesia'
                    ],
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>',
                        'title' => 'Dukungan 24/7',
                        'description' => 'Tim support siap membantu kapan saja Anda butuhkan'
                    ],
                ];
            @endphp

            @foreach($features as $index => $feature)
                <div 
                    x-data="{ hovered: false }"
                    @mouseenter="hovered = true"
                    @mouseleave="hovered = false"
                    class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-primary-200 hover:-translate-y-2"
                >
                    <!-- Icon -->
                    <div 
                        :class="hovered ? 'scale-110 rotate-3' : ''"
                        class="w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center mb-6 transition-transform duration-300"
                    >
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            {!! $feature['icon'] !!}
                        </svg>
                    </div>

                    <!-- Content -->
                    <h3 class="text-xl font-bold text-dark mb-3 group-hover:text-primary-600 transition-colors">
                        {{ $feature['title'] }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $feature['description'] }}
                    </p>

                    <!-- Hover Effect -->
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                </div>
            @endforeach
        </div>
    </div>
</section>
