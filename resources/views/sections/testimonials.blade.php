<!-- Testimonials Section -->
<section id="testimonials" class="py-20 lg:py-28 bg-dark relative overflow-hidden">
    <!-- Animated Mesh Gradient Background -->
    <div class="absolute inset-0 opacity-30">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-500 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-accent-500 rounded-full blur-[120px] animate-pulse" style="animation-delay: 1s;"></div>
    </div>

    <div class="w-full px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4">
                Apa Kata <span class="gradient-text">Mereka</span>?
            </h2>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Pengalaman nyata dari traveler yang telah menjelajahi Indonesia bersama kami
            </p>
        </div>

        <!-- Testimonials Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 max-w-6xl mx-auto mb-16">
            @foreach($reviews as $review)
                <div class="group relative bg-white/5 backdrop-blur-sm rounded-2xl p-8 border border-white/10 hover:border-primary-500/50 transition-all duration-500 hover:-translate-y-2">
                    <!-- Quote Icon -->
                    <svg class="w-10 h-10 text-primary-500/30 mb-4 group-hover:text-primary-500/50 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>

                    <!-- Content -->
                    <p class="text-gray-300 leading-relaxed mb-6">
                        "{{ $review->comment }}"
                    </p>

                    <!-- Rating -->
                    <div class="flex gap-1 mb-6">
                        @for($i = 0; $i < $review->rating; $i++)
                            <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>

                    <!-- Author -->
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-primary-500/50 group-hover:border-primary-500 transition-colors">
                            <img 
                                src="{{ $review->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) . '&background=random' }}" 
                                alt="{{ $review->user->name }}"
                                class="w-full h-full object-cover"
                            >
                        </div>
                        <div>
                            <h4 class="text-white font-semibold">{{ $review->user->name }}</h4>
                            <p class="text-gray-400 text-sm">{{ $review->user->role ?? 'Traveler' }}</p>
                            <p class="text-primary-400 text-xs mt-1">{{ $review->package->title }}</p>
                        </div>
                    </div>

                    <!-- Hover Glow -->
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                </div>
            @endforeach
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
            @php
                $stats = [
                    ['value' => '50,000+', 'label' => 'Travelers'],
                    ['value' => '1,200+', 'label' => 'Paket Wisata'],
                    ['value' => '4.9', 'label' => 'Rating Rata-rata'],
                    ['value' => '98%', 'label' => 'Kepuasan Pelanggan'],
                ];
            @endphp

            @foreach($stats as $stat)
                <div class="text-center p-6 bg-white/5 rounded-xl border border-white/10">
                    <div class="text-3xl sm:text-4xl font-bold gradient-text">{{ $stat['value'] }}</div>
                    <div class="text-gray-400 text-sm">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
