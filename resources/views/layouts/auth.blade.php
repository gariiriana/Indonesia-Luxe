<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Indonesia Luxe')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="min-h-screen flex" style="background: linear-gradient(135deg, #fef3c7 0%, #ffffff 40%, #fff7ed 100%);">

    {{-- Left decorative panel (desktop only) --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden" style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 50%, #92400e 100%);">
        {{-- Decorative circles --}}
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-white/10 rounded-full"></div>
        <div class="absolute top-1/3 right-10 w-32 h-32 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col justify-between p-12 text-white w-full">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <span class="text-white text-lg font-serif font-bold">IL</span>
                </div>
                <span class="font-serif font-semibold tracking-widest text-sm">INDONESIA LUXE</span>
            </a>

            {{-- Center content --}}
            <div>
                <h2 class="text-4xl font-serif font-bold mb-4 leading-tight">
                    Jelajahi<br>Keindahan<br>Nusantara
                </h2>
                <p class="text-amber-100 text-base leading-relaxed mb-8">
                    Platform tour & travel premium terpercaya. Temukan ribuan paket wisata dari Sabang sampai Merauke.
                </p>
                {{-- Stats --}}
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white/15 rounded-xl p-3 text-center">
                        <div class="text-2xl font-bold">500+</div>
                        <div class="text-xs text-amber-200 mt-0.5">Paket Tour</div>
                    </div>
                    <div class="bg-white/15 rounded-xl p-3 text-center">
                        <div class="text-2xl font-bold">50+</div>
                        <div class="text-xs text-amber-200 mt-0.5">Destinasi</div>
                    </div>
                    <div class="bg-white/15 rounded-xl p-3 text-center">
                        <div class="text-2xl font-bold">10K+</div>
                        <div class="text-xs text-amber-200 mt-0.5">Wisatawan</div>
                    </div>
                </div>
            </div>

            {{-- Bottom quote --}}
            <div class="border-t border-white/20 pt-6">
                <p class="text-amber-100 text-sm italic">"Setiap perjalanan adalah petualangan yang tak terlupakan"</p>
                <div class="flex items-center gap-2 mt-3">
                    <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center text-xs">IL</div>
                    <span class="text-white/70 text-xs">Indonesia Luxe Team</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Form Panel --}}
    <div class="flex-1 flex items-center justify-center p-6 lg:p-12 min-h-screen">
        @yield('content')
    </div>

    <script>lucide.createIcons();</script>
    @stack('scripts')
</body>

</html>