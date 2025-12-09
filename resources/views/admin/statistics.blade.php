@extends('admin.layouts.app')

@section('title', 'Statistics')
@section('page_title', 'Statistics')

@section('content')
<div class="mb-6 pr-6">
    <h3 class="text-xl font-bold text-gray-900">Statistik & Laporan</h3>
    <p class="text-sm text-gray-500 mt-1">Overview performa dan data booking</p>
</div>

<!-- Revenue Card -->
<div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow p-6 mb-6 mr-6">
    <div class="flex items-center justify-between text-white">
        <div>
            <p class="text-green-100 text-sm font-medium mb-2">Revenue Bulan Ini</p>
            <h2 class="text-3xl font-bold">Rp {{ number_format($monthlyRevenue ?? 0, 0, ',', '.') }}</h2>
            <p class="text-green-100 text-xs mt-2">{{ now()->format('F Y') }}</p>
        </div>
        <div class="bg-white bg-opacity-20 p-4 rounded-lg">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Booking by Status -->
    <div class="bg-white rounded-lg shadow p-6 mr-6 lg:mr-0">
        <h4 class="text-base font-semibold text-gray-800 mb-4">Booking berdasarkan Status</h4>
        <div class="space-y-3">
            @foreach($bookingsByStatus as $stat)
                @php
                    $statusConfig = [
                        'pending' => ['label' => 'Pending', 'color' => 'orange', 'bg' => 'bg-orange-100', 'text' => 'text-orange-700'],
                        'confirmed' => ['label' => 'Confirmed', 'color' => 'blue', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
                        'completed' => ['label' => 'Completed', 'color' => 'green', 'bg' => 'bg-green-100', 'text' => 'text-green-700'],
                        'cancelled' => ['label' => 'Cancelled', 'color' => 'red', 'bg' => 'bg-red-100', 'text' => 'text-red-700'],
                    ];
                    $config = $statusConfig[$stat->status] ?? ['label' => ucfirst($stat->status), 'color' => 'gray', 'bg' => 'bg-gray-100', 'text' => 'text-gray-700'];
                @endphp
                <div class="flex items-center justify-between p-3 {{ $config['bg'] }} rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full {{ $config['bg'] }} flex items-center justify-center {{ $config['text'] }} font-bold">
                            {{ $stat->count }}
                        </div>
                        <span class="font-medium {{ $config['text'] }}">{{ $config['label'] }}</span>
                    </div>
                    <div class="text-sm {{ $config['text'] }} font-semibold">
                        {{ number_format(($stat->count / $bookingsByStatus->sum('count')) * 100, 1) }}%
                    </div>
                </div>
            @endforeach

            @if($bookingsByStatus->isEmpty())
                <div class="text-center py-8 text-gray-400">
                    <p class="text-sm">Belum ada data booking</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Popular Services -->
    <div class="bg-white rounded-lg shadow p-6 mr-6">
        <h4 class="text-base font-semibold text-gray-800 mb-4">Layanan Terpopuler</h4>
        <div class="space-y-3">
            @forelse($popularServices as $index => $service)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                            #{{ $index + 1 }}
                        </div>
                        <div>
                            <div class="font-medium text-gray-800">{{ $service->name }}</div>
                            <div class="text-xs text-gray-500">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-bold text-gray-800">{{ $service->bookings_count }}</div>
                        <div class="text-xs text-gray-500">bookings</div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-400">
                    <p class="text-sm">Belum ada data layanan</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Additional Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 pr-6">
    <div class="bg-white rounded-lg shadow p-5 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs font-medium mb-1">Total Services</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ \App\Models\Service::count() }}</h3>
                <p class="text-gray-400 text-xs mt-1">Layanan tersedia</p>
            </div>
            <div class="bg-blue-50 p-3 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-5 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs font-medium mb-1">Total Users</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ \App\Models\User::where('role', 'user')->count() }}</h3>
                <p class="text-gray-400 text-xs mt-1">Pengguna terdaftar</p>
            </div>
            <div class="bg-purple-50 p-3 rounded-lg">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-5 border-l-4 border-orange-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs font-medium mb-1">Avg. Booking Value</p>
                <h3 class="text-2xl font-bold text-gray-800">
                    Rp {{ number_format(\App\Models\Payment::where('status', 'success')->avg('amount') ?? 0, 0, ',', '.') }}
                </h3>
                <p class="text-gray-400 text-xs mt-1">Rata-rata transaksi</p>
            </div>
            <div class="bg-orange-50 p-3 rounded-lg">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            </div>
        </div>
    </div>
</div>
@endsection
