@extends('layouts.app')

@section('title', $package->title . ' - Indonesia Luxe')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Breadcrumb & Actions -->
        <div class="bg-white border-b sticky top-16 z-30">
            <div class="w-full px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <a href="{{ url()->previous() }}" class="flex items-center gap-2 text-gray-600 hover:text-primary-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali
                    </a>
                    <div class="flex gap-2">
                        <button class="p-2 hover:bg-gray-100 rounded-lg">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                        </button>
                        <button class="p-2 hover:bg-gray-100 rounded-lg">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero Image -->
        <div class="relative h-[400px] lg:h-[500px]">
            <img 
                src="{{ $package->image }}" 
                alt="{{ $package->title }}"
                class="w-full h-full object-cover"
                onerror="this.src='https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&q=80'"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-dark/60 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6 lg:p-10">
                <div class="w-full px-4 sm:px-6 lg:px-8">
                    <span class="inline-block bg-secondary-500 text-white text-sm font-medium px-3 py-1 rounded-full mb-4">
                        {{ $package->discount_percentage }}% OFF
                    </span>
                    <h1 class="text-3xl lg:text-5xl font-bold text-white mb-4">
                        {{ $package->title }}
                    </h1>
                    <div class="flex flex-wrap items-center gap-4 text-white/90">
                        <span class="flex items-center gap-1">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $package->destination->name }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $package->duration }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            {{ $package->rating }} ({{ $package->review_count }} reviews)
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Main Content -->
                <div class="flex-1">
                    <div class="bg-white rounded-xl shadow-sm" x-data="{ activeTab: 'overview' }">
                        <!-- Tabs -->
                        <div class="flex border-b">
                            <button 
                                @click="activeTab = 'overview'"
                                :class="activeTab === 'overview' ? 'border-b-2 border-primary-500 text-primary-600' : 'text-gray-600'"
                                class="px-6 py-4 font-medium transition-colors"
                            >
                                Ikhtisar
                            </button>
                            <button 
                                @click="activeTab = 'itinerary'"
                                :class="activeTab === 'itinerary' ? 'border-b-2 border-primary-500 text-primary-600' : 'text-gray-600'"
                                class="px-6 py-4 font-medium transition-colors"
                            >
                                Itinerary
                            </button>
                            <button 
                                @click="activeTab = 'inclusions'"
                                :class="activeTab === 'inclusions' ? 'border-b-2 border-primary-500 text-primary-600' : 'text-gray-600'"
                                class="px-6 py-4 font-medium transition-colors"
                            >
                                Termasuk
                            </button>
                        </div>

                        <!-- Tab Content -->
                        <div class="p-6">
                            <!-- Overview -->
                            <div x-show="activeTab === 'overview'" x-transition>
                                <h3 class="text-xl font-bold mb-4">Tentang Paket</h3>
                                <p class="text-gray-600 leading-relaxed mb-6">
                                    {{ $package->description }}
                                </p>
                                
                                <h4 class="font-semibold mb-3">Highlights</h4>
                                <ul class="space-y-2">
                                    @foreach(array_slice($package->inclusions, 0, 3) as $inclusion)
                                        <li class="flex items-center gap-2 text-gray-600">
                                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            {{ $inclusion }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Itinerary -->
                            <div x-show="activeTab === 'itinerary'" x-transition x-cloak>
                                <h3 class="text-xl font-bold mb-4">Rencana Perjalanan</h3>
                                <div class="space-y-6">
                                    @foreach($package->itinerary as $day)
                                        <div class="border-l-2 border-primary-500 pl-6 pb-6">
                                            <div class="flex items-center gap-3 mb-3">
                                                <span class="w-8 h-8 bg-primary-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                                                    {{ $day['day'] }}
                                                </span>
                                                <h4 class="font-semibold">{{ $day['title'] }}</h4>
                                            </div>
                                            <ul class="space-y-2">
                                                @foreach($day['activities'] as $activity)
                                                    <li class="flex items-center gap-2 text-gray-600 text-sm">
                                                        <div class="w-1.5 h-1.5 bg-gray-400 rounded-full"></div>
                                                        {{ $activity }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Inclusions -->
                            <div x-show="activeTab === 'inclusions'" x-transition x-cloak>
                                <h3 class="text-xl font-bold mb-4">Termasuk dalam Paket</h3>
                                <ul class="space-y-3">
                                    @foreach($package->inclusions as $inclusion)
                                        <li class="flex items-center gap-3 text-gray-600">
                                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                            {{ $inclusion }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Card -->
                <div class="lg:w-96">
                    <div class="sticky top-24 bg-white rounded-xl shadow-lg p-6">
                        <!-- Price -->
                        <div class="mb-6">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-gray-400 line-through">{{ $package->formatted_original_price }}</span>
                                <span class="bg-secondary-500 text-white text-xs font-bold px-2 py-0.5 rounded">
                                    {{ $package->discount_percentage }}% OFF
                                </span>
                            </div>
                            <div class="text-3xl font-bold text-primary-600">
                                {{ $package->formatted_price }}
                            </div>
                            <span class="text-gray-500 text-sm">/orang</span>
                        </div>

                        <!-- Booking Form -->
                        <form action="{{ route('cart') }}" method="GET" class="space-y-4">
                            <!-- Date -->
                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Pilih Tanggal
                                </label>
                                <input 
                                    type="date" 
                                    name="date"
                                    min="{{ date('Y-m-d') }}"
                                    required
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                >
                            </div>

                            <!-- Travelers -->
                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    Jumlah Traveler
                                </label>
                                <div class="flex items-center gap-3">
                                    <button type="button" onclick="decrementTravelers()" class="w-10 h-10 border border-gray-200 rounded-lg flex items-center justify-center hover:bg-gray-50">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                        </svg>
                                    </button>
                                    <input 
                                        type="number" 
                                        name="travelers"
                                        id="travelers"
                                        value="1"
                                        min="1"
                                        class="w-16 text-center font-semibold border-0"
                                        readonly
                                    >
                                    <button type="button" onclick="incrementTravelers()" class="w-10 h-10 border border-gray-200 rounded-lg flex items-center justify-center hover:bg-gray-50">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="border-t pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Total</span>
                                    <span class="text-2xl font-bold text-primary-600" id="total-price">
                                        {{ $package->formatted_price }}
                                    </span>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white py-4 rounded-xl font-semibold transition-colors">
                                Tambah ke Keranjang
                            </button>
                            <a href="{{ route('cart') }}" class="block w-full text-center py-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                                Lihat Keranjang
                            </a>

                            <!-- Hidden inputs -->
                            <input type="hidden" name="package_id" value="{{ $package->id }}">

                            <!-- Guarantee -->
                            <div class="mt-4 pt-4 border-t text-center">
                                <p class="text-sm text-gray-500">
                                    Gratis pembatalan hingga 24 jam sebelum keberangkatan
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const pricePerPerson = {{ $package->discounted_price }};
        
        function incrementTravelers() {
            const input = document.getElementById('travelers');
            input.value = parseInt(input.value) + 1;
            updateTotal();
        }
        
        function decrementTravelers() {
            const input = document.getElementById('travelers');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                updateTotal();
            }
        }
        
        function updateTotal() {
            const travelers = document.getElementById('travelers').value;
            const total = pricePerPerson * travelers;
            document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    </script>
@endsection
