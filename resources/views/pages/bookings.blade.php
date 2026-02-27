@extends('layouts.app')

@section('title', 'Pesanan Saya - Indonesia Luxe')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-serif text-gray-900 mb-6">Pesanan Saya</h1>

        {{-- Status Tabs --}}
        <div class="flex gap-2 mb-6 overflow-x-auto pb-1">
            @foreach(['all' => 'Semua', 'pending' => 'Menunggu', 'paid' => 'Dibayar', 'confirmed' => 'Dikonfirmasi', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $key => $label)
                <a href="{{ route('bookings', ['status' => $key]) }}"
                    class="shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition
                          {{ $status === $key ? 'bg-amber-500 text-white' : 'bg-white text-gray-600 hover:bg-amber-50 border border-gray-200' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if($bookings->isEmpty())
            <div class="text-center py-20 bg-white rounded-2xl shadow-sm">
                <i data-lucide="package" class="w-16 h-16 text-gray-200 mx-auto mb-4"></i>
                <h3 class="text-xl text-gray-500 mb-2">Belum ada pesanan</h3>
                <a href="{{ route('search') }}"
                    class="mt-4 inline-flex items-center gap-2 bg-amber-500 text-white px-6 py-3 rounded-xl hover:bg-amber-600 transition">
                    <i data-lucide="search" class="w-5 h-5"></i> Cari Tour
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($bookings as $booking)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <img src="{{ $booking->package->image }}" alt="{{ $booking->package->title }}"
                                class="w-full sm:w-28 h-32 sm:h-24 rounded-xl object-cover shrink-0">
                            <div class="flex-1">
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <div>
                                        <p class="text-xs text-gray-400 mb-1">{{ $booking->booking_code }}</p>
                                        <h3 class="font-semibold text-gray-900">{{ $booking->package->title }}</h3>
                                    </div>
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'paid' => 'bg-blue-100 text-blue-700',
                                            'confirmed' => 'bg-indigo-100 text-indigo-700',
                                            'completed' => 'bg-green-100 text-green-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Menunggu Pembayaran',
                                            'paid' => 'Dibayar',
                                            'confirmed' => 'Dikonfirmasi',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    <span
                                        class="shrink-0 text-xs px-3 py-1 rounded-full {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ $statusLabels[$booking->status] ?? $booking->status }}
                                    </span>
                                </div>
                                <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-3">
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="calendar" class="w-4 h-4 text-amber-500"></i>
                                        {{ $booking->travel_date->format('d M Y') }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="users" class="w-4 h-4 text-amber-500"></i>
                                        {{ $booking->travelers }} peserta
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="clock" class="w-4 h-4 text-amber-500"></i>
                                        {{ $booking->package->duration }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold text-amber-600">
                                        Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                    </span>
                                    <div class="flex gap-2">
                                        @if(in_array($booking->status, ['pending', 'paid']))
                                            <form action="{{ route('bookings.cancel', $booking) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin membatalkan pesanan?')">
                                                @csrf
                                                <button type="submit" class="text-xs text-red-600 hover:underline">Batalkan</button>
                                            </form>
                                        @endif
                                        @if($booking->status === 'completed' && !$booking->review)
                                            <a href="#" class="text-xs text-amber-600 hover:underline">Tulis Review</a>
                                        @endif
                                        <a href="{{ route('bookings.show', $booking) }}"
                                            class="text-xs text-amber-600 hover:underline">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
@endsection