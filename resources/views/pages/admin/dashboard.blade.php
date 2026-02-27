@extends('layouts.app')

@section('title', 'Admin Dashboard - Indonesia Luxe')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-serif text-gray-900 mb-6">Admin Dashboard</h1>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-8">
        @foreach([
            ['icon' => 'users', 'value' => $stats['total_users'], 'label' => 'Users', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50'],
            ['icon' => 'briefcase', 'value' => $stats['total_vendors'], 'label' => 'Vendors', 'color' => 'text-indigo-500', 'bg' => 'bg-indigo-50'],
            ['icon' => 'package', 'value' => $stats['total_packages'], 'label' => 'Paket', 'color' => 'text-green-500', 'bg' => 'bg-green-50'],
            ['icon' => 'shopping-bag', 'value' => $stats['total_bookings'], 'label' => 'Booking', 'color' => 'text-purple-500', 'bg' => 'bg-purple-50'],
            ['icon' => 'banknote', 'value' => 'Rp '.number_format($stats['total_revenue']/1000000, 1).'Jt', 'label' => 'Revenue', 'color' => 'text-amber-500', 'bg' => 'bg-amber-50'],
            ['icon' => 'clock', 'value' => $stats['pending_packages'], 'label' => 'Pending Paket', 'color' => 'text-yellow-500', 'bg' => 'bg-yellow-50'],
            ['icon' => 'user-check', 'value' => $stats['pending_vendors'], 'label' => 'Pending Vendor', 'color' => 'text-orange-500', 'bg' => 'bg-orange-50'],
        ] as $stat)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
            <div class="{{ $stat['bg'] }} w-9 h-9 rounded-xl flex items-center justify-center mb-3">
                <i data-lucide="{{ $stat['icon'] }}" class="w-4.5 h-4.5 {{ $stat['color'] }}"></i>
            </div>
            <div class="text-xl font-bold text-gray-900">{{ $stat['value'] }}</div>
            <div class="text-xs text-gray-500">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Tabs --}}
    <div x-data="{ tab: 'bookings' }">
        <div class="flex gap-2 mb-5 overflow-x-auto pb-1">
            @foreach(['bookings' => 'Booking Terbaru', 'packages' => 'Pending Paket', 'vendors' => 'Pending Vendor'] as $key => $label)
            <button @click="tab='{{ $key }}'"
                    :class="tab==='{{ $key }}' ? 'bg-amber-500 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-amber-50'"
                    class="shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition">
                {{ $label }}
            </button>
            @endforeach
        </div>

        {{-- Recent Bookings --}}
        <div x-show="tab==='bookings'" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex justify-between items-center px-5 py-4 border-b border-gray-100">
                <h2 class="font-semibold">Booking Terbaru</h2>
                <a href="{{ route('admin.bookings') }}" class="text-sm text-amber-600 hover:underline">Lihat semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-5 py-3 text-left">Kode</th>
                            <th class="px-5 py-3 text-left">User</th>
                            <th class="px-5 py-3 text-left">Paket</th>
                            <th class="px-5 py-3 text-left">Total</th>
                            <th class="px-5 py-3 text-left">Status</th>
                            <th class="px-5 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($recentBookings as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3 font-mono text-xs">{{ $booking->booking_code }}</td>
                            <td class="px-5 py-3">{{ $booking->user->name }}</td>
                            <td class="px-5 py-3 max-w-[180px] line-clamp-1">{{ $booking->package->title }}</td>
                            <td class="px-5 py-3 text-amber-600 font-medium">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</td>
                            <td class="px-5 py-3">
                                @php $sc = ['pending'=>'bg-yellow-100 text-yellow-700','paid'=>'bg-blue-100 text-blue-700','confirmed'=>'bg-indigo-100 text-indigo-700','completed'=>'bg-green-100 text-green-700','cancelled'=>'bg-red-100 text-red-700'][$booking->status]??'bg-gray-100 text-gray-600'; @endphp
                                <span class="text-xs px-2 py-0.5 rounded-full {{ $sc }}">{{ ucfirst($booking->status) }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="flex gap-1">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()"
                                            class="text-xs border rounded-lg px-2 py-1 focus:ring-amber-500 focus:border-amber-500">
                                        @foreach(['pending','paid','confirmed','completed','cancelled'] as $s)
                                        <option value="{{ $s }}" {{ $booking->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pending Packages --}}
        <div x-show="tab==='packages'" x-cloak class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex justify-between items-center px-5 py-4 border-b border-gray-100">
                <h2 class="font-semibold">Paket Menunggu Approval</h2>
                <a href="{{ route('admin.packages') }}" class="text-sm text-amber-600 hover:underline">Lihat semua</a>
            </div>
            @if($pendingPackages->isEmpty())
            <div class="text-center py-10 text-gray-400 text-sm">Tidak ada paket yang menunggu.</div>
            @else
            <div class="divide-y divide-gray-50">
                @foreach($pendingPackages as $pkg)
                <div class="flex items-center gap-4 px-5 py-4">
                    <img src="{{ $pkg->image }}" alt="" class="w-12 h-12 rounded-xl object-cover shrink-0">
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 truncate">{{ $pkg->title }}</p>
                        <p class="text-sm text-gray-500">{{ $pkg->vendor->business_name ?? 'Vendor' }} · {{ $pkg->category->name ?? '-' }}</p>
                    </div>
                    <p class="text-amber-600 font-medium shrink-0">{{ $pkg->formatted_price }}</p>
                    <div class="flex gap-2 shrink-0">
                        <form action="{{ route('admin.packages.approve', $pkg) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white rounded-lg text-xs font-medium transition">Approve</button>
                        </form>
                        <form action="{{ route('admin.packages.reject', $pkg) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs font-medium transition">Tolak</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Pending Vendors --}}
        <div x-show="tab==='vendors'" x-cloak class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex justify-between items-center px-5 py-4 border-b border-gray-100">
                <h2 class="font-semibold">Vendor Menunggu Approval</h2>
                <a href="{{ route('admin.vendors') }}" class="text-sm text-amber-600 hover:underline">Lihat semua</a>
            </div>
            @if($pendingVendors->isEmpty())
            <div class="text-center py-10 text-gray-400 text-sm">Tidak ada vendor yang menunggu.</div>
            @else
            <div class="divide-y divide-gray-50">
                @foreach($pendingVendors as $vendor)
                <div class="flex items-center gap-4 px-5 py-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 text-lg font-bold shrink-0">
                        {{ strtoupper(substr($vendor->business_name ?? 'V', 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">{{ $vendor->business_name }}</p>
                        <p class="text-sm text-gray-500">{{ $vendor->user->email }}</p>
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <form action="{{ route('admin.vendors.approve', $vendor) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white rounded-lg text-xs font-medium transition">Approve</button>
                        </form>
                        <form action="{{ route('admin.vendors.reject', $vendor) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs font-medium transition">Tolak</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- Quick Nav --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
        @foreach([
            ['route' => 'admin.users', 'icon' => 'users', 'label' => 'Manage Users'],
            ['route' => 'admin.packages', 'icon' => 'package', 'label' => 'Manage Paket'],
            ['route' => 'admin.vendors', 'icon' => 'briefcase', 'label' => 'Manage Vendor'],
            ['route' => 'admin.promo-codes', 'icon' => 'tag', 'label' => 'Promo Codes'],
        ] as $link)
        <a href="{{ route($link['route']) }}"
           class="flex items-center gap-3 bg-white border border-gray-100 rounded-2xl p-4 hover:shadow-md hover:border-amber-200 transition group">
            <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-100 transition">
                <i data-lucide="{{ $link['icon'] }}" class="w-5 h-5 text-amber-500"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">{{ $link['label'] }}</span>
        </a>
        @endforeach
    </div>
</div>
@endsection
