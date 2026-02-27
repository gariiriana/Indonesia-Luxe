@extends('layouts.app')

@section('title', 'Vendor Dashboard - Indonesia Luxe')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-serif text-gray-900">Vendor Dashboard</h1>
            <p class="text-gray-500 text-sm mt-0.5">{{ $vendor->business_name }}</p>
        </div>
        <a href="{{ route('vendor.packages.create') }}"
           class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-xl font-medium transition">
            <i data-lucide="plus" class="w-5 h-5"></i> Tambah Paket
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['icon' => 'package', 'value' => $packages->total(), 'label' => 'Total Paket', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50'],
            ['icon' => 'shopping-bag', 'value' => $totalBookings, 'label' => 'Total Booking', 'color' => 'text-green-500', 'bg' => 'bg-green-50'],
            ['icon' => 'star', 'value' => number_format($avgRating, 1), 'label' => 'Rating Avg', 'color' => 'text-amber-500', 'bg' => 'bg-amber-50'],
            ['icon' => 'banknote', 'value' => 'Rp '.number_format($totalRevenue, 0, ',', '.'), 'label' => 'Total Pendapatan', 'color' => 'text-purple-500', 'bg' => 'bg-purple-50'],
        ] as $stat)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="w-10 h-10 {{ $stat['bg'] }} rounded-xl flex items-center justify-center mb-3">
                <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5 {{ $stat['color'] }}"></i>
            </div>
            <div class="text-xl font-bold text-gray-900">{{ $stat['value'] }}</div>
            <div class="text-sm text-gray-500">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>

    @if($pendingPackages > 0)
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl px-4 py-3 mb-6 flex items-center gap-2 text-yellow-800">
        <i data-lucide="clock" class="w-5 h-5 shrink-0"></i>
        {{ $pendingPackages }} paket menunggu review dari admin
    </div>
    @endif

    {{-- Packages Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900">Daftar Paket Tour</h2>
        </div>
        @if($packages->isEmpty())
        <div class="text-center py-12 text-gray-400">
            <i data-lucide="package" class="w-12 h-12 mx-auto mb-2 opacity-30"></i>
            <p>Belum ada paket tour. <a href="{{ route('vendor.packages.create') }}" class="text-amber-600 hover:underline">Tambah sekarang</a></p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">Paket</th>
                        <th class="px-6 py-3 text-left">Kategori</th>
                        <th class="px-6 py-3 text-left">Harga</th>
                        <th class="px-6 py-3 text-left">Booking</th>
                        <th class="px-6 py-3 text-left">Rating</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($packages as $pkg)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $pkg->image }}" alt="" class="w-10 h-10 rounded-lg object-cover shrink-0">
                                <span class="text-sm font-medium text-gray-900 line-clamp-2 max-w-[200px]">{{ $pkg->title }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $pkg->category->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-amber-600">{{ $pkg->formatted_price }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $pkg->bookings_count ?? $pkg->bookings->count() }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1 text-sm">
                                <i data-lucide="star" class="w-4 h-4 fill-amber-400 text-amber-400"></i>
                                {{ $pkg->rating }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php $statusClass = ['approved' => 'bg-green-100 text-green-700','pending' => 'bg-yellow-100 text-yellow-700','rejected' => 'bg-red-100 text-red-700'][$pkg->status] ?? 'bg-gray-100 text-gray-600'; @endphp
                            <span class="text-xs px-2.5 py-1 rounded-full {{ $statusClass }}">{{ ucfirst($pkg->status) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('vendor.packages.edit', $pkg) }}" class="p-1.5 hover:bg-amber-50 rounded-lg text-amber-600 transition">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('vendor.packages.destroy', $pkg) }}" method="POST"
                                      onsubmit="return confirm('Hapus paket ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 hover:bg-red-50 rounded-lg text-red-500 transition">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $packages->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
