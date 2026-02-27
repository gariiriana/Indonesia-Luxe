@extends('layouts.app')

@section('title', 'Profil Saya - Indonesia Luxe')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">

    {{-- Profile Header --}}
    <div class="bg-gradient-to-r from-amber-500 to-amber-600 rounded-3xl p-6 md:p-8 mb-6 text-white">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
            <div class="relative">
                @if($user->avatar)
                <img src="{{ asset('storage/'.$user->avatar) }}" alt=""
                     class="w-24 h-24 rounded-2xl object-cover border-4 border-white/30">
                @else
                <div class="w-24 h-24 rounded-2xl bg-white/20 flex items-center justify-center text-4xl font-bold border-4 border-white/30">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                @endif
                <a href="{{ route('profile.edit') }}"
                   class="absolute -bottom-2 -right-2 w-7 h-7 bg-white rounded-full flex items-center justify-center shadow-md">
                    <i data-lucide="pencil" class="w-3.5 h-3.5 text-amber-600"></i>
                </a>
            </div>
            <div>
                <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                <p class="text-amber-100 mb-3">{{ $user->email }}</p>
                <div class="flex flex-wrap gap-2">
                    <span class="text-xs bg-white/20 px-3 py-1 rounded-full capitalize">{{ $user->role }}</span>
                    @if($user->phone)
                    <span class="text-xs bg-white/20 px-3 py-1 rounded-full">{{ $user->phone }}</span>
                    @endif
                </div>
            </div>
            <div class="sm:ml-auto">
                <a href="{{ route('profile.edit') }}"
                   class="inline-flex items-center gap-2 bg-white text-amber-600 px-4 py-2 rounded-xl text-sm font-medium hover:bg-amber-50 transition">
                    <i data-lucide="edit" class="w-4 h-4"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        @foreach([
            ['icon' => 'package', 'value' => $bookingsCount, 'label' => 'Total Pesanan', 'route' => 'bookings'],
            ['icon' => 'heart', 'value' => $wishlistCount, 'label' => 'Wishlist', 'route' => 'profile.wishlist'],
            ['icon' => 'star', 'value' => $reviewsCount, 'label' => 'Ulasan', 'route' => 'profile.reviews'],
            ['icon' => 'zap', 'value' => number_format($luxePoints), 'label' => 'Luxe Points', 'route' => 'profile.luxe-points'],
        ] as $stat)
        <a href="{{ route($stat['route']) }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center hover:shadow-md transition group">
            <i data-lucide="{{ $stat['icon'] }}" class="w-8 h-8 mx-auto mb-2 text-amber-500 group-hover:scale-110 transition-transform"></i>
            <div class="text-2xl font-bold text-gray-900">{{ $stat['value'] }}</div>
            <div class="text-sm text-gray-500">{{ $stat['label'] }}</div>
        </a>
        @endforeach
    </div>

    {{-- Quick Links --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <h2 class="font-semibold text-gray-900 px-6 py-4 border-b border-gray-100">Menu Akun</h2>
        <div class="divide-y divide-gray-50">
            @php
            $profileLinks = [
                ['route' => 'bookings', 'icon' => 'package', 'label' => 'Pesanan Saya', 'desc' => 'Riwayat dan status booking'],
                ['route' => 'profile.wishlist', 'icon' => 'heart', 'label' => 'Wishlist', 'desc' => 'Tour yang disimpan'],
                ['route' => 'profile.reviews', 'icon' => 'star', 'label' => 'Ulasan Saya', 'desc' => 'Review yang pernah ditulis'],
                ['route' => 'profile.participants', 'icon' => 'users', 'label' => 'Data Peserta', 'desc' => 'Simpan data peserta perjalanan'],
                ['route' => 'profile.delivery', 'icon' => 'map-pin', 'label' => 'Alamat Pengiriman', 'desc' => 'Kelola alamat Anda'],
                ['route' => 'profile.promo-codes', 'icon' => 'tag', 'label' => 'Kode Promo', 'desc' => 'Promo yang tersedia'],
                ['route' => 'profile.luxe-points', 'icon' => 'zap', 'label' => 'Luxe Points', 'desc' => number_format($luxePoints) . ' poin tersedia'],
                ['route' => 'profile.gift-cards', 'icon' => 'gift', 'label' => 'Gift Card', 'desc' => 'Kelola kartu hadiah'],
                ['route' => 'profile.settings', 'icon' => 'settings', 'label' => 'Pengaturan', 'desc' => 'Notifikasi & keamanan akun'],
            ];
            @endphp
            @foreach($profileLinks as $link)
            <a href="{{ route($link['route']) }}"
               class="flex items-center gap-4 px-6 py-4 hover:bg-amber-50 transition group">
                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center shrink-0 group-hover:bg-amber-200 transition">
                    <i data-lucide="{{ $link['icon'] }}" class="w-5 h-5 text-amber-600"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-900">{{ $link['label'] }}</p>
                    <p class="text-xs text-gray-500">{{ $link['desc'] }}</p>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-300 group-hover:text-amber-500 transition"></i>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
