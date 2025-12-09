@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('page_title', 'Dashboard')

@section('content')
    <!-- Stats cards simple -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6 pr-6">
        <!-- Total Booking -->
        <div class="bg-white rounded-lg p-5 shadow border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-xs font-medium mb-1">Total Booking</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_bookings'] ?? 0) }}</h3>
                        <p class="text-gray-400 text-xs mt-1">Semua booking</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                </div>
            </div>

            <!-- Pending -->
            <div class="bg-white rounded-lg p-5 shadow border-l-4 border-orange-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-xs font-medium mb-1">Pending</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['pending_bookings'] ?? 0) }}</h3>
                        <p class="text-gray-400 text-xs mt-1">Menunggu konfirmasi</p>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

            <!-- Aktif -->
            <div class="bg-white rounded-lg p-5 shadow border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-xs font-medium mb-1">Aktif</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['confirmed_bookings'] ?? 0) }}</h3>
                        <p class="text-gray-400 text-xs mt-1">Terkonfirmasi</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

            <!-- Selesai -->
            <div class="bg-white rounded-lg p-5 shadow border-l-4 border-gray-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-xs font-medium mb-1">Selesai</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['completed_bookings'] ?? 0) }}</h3>
                        <p class="text-gray-400 text-xs mt-1">Booking selesai</p>
                    </div>
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
            </div>
    </div>

    <!-- Chart + Quick Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6 pr-6">
            <!-- Chart area -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">Statistik Booking</h3>
                        <p class="text-xs text-gray-500 mt-1">Grafik booking 7 hari terakhir</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="px-3 py-1 text-xs font-medium bg-blue-600 text-white rounded-md">7 Hari</button>
                        <button class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-md hover:bg-gray-200">30 Hari</button>
                    </div>
                </div>
                <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center border border-dashed border-gray-300">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <p class="text-gray-400 text-sm">Chart akan ditampilkan di sini</p>
                    </div>
                </div>
            </div>

            <!-- Quick stats sidebar -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-base font-semibold text-gray-800 mb-4">Ringkasan Cepat</h3>
                <div class="space-y-3">
                    <div class="bg-blue-50 rounded-lg p-4 border-l-3 border-blue-500">
                        <p class="text-xs text-gray-600 font-medium mb-1">Revenue Hari Ini</p>
                        <p class="text-lg font-bold text-gray-800">Rp 0</p>
                    </div>

                    <div class="bg-green-50 rounded-lg p-4 border-l-3 border-green-500">
                        <p class="text-xs text-gray-600 font-medium mb-1">Booking Hari Ini</p>
                        <p class="text-lg font-bold text-gray-800">0</p>
                    </div>

                    <div class="bg-orange-50 rounded-lg p-4 border-l-3 border-orange-500">
                        <p class="text-xs text-gray-600 font-medium mb-1">Perlu Konfirmasi</p>
                        <p class="text-lg font-bold text-gray-800">{{ $stats['pending_bookings'] ?? 0 }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 border-l-3 border-gray-400">
                        <p class="text-xs text-gray-600 font-medium mb-1">Total Revenue</p>
                        <p class="text-lg font-bold text-gray-800">Rp 0</p>
                    </div>
            </div>
        </div>
    </div>

    <!-- Recent bookings -->
    <div class="bg-white rounded-lg shadow mr-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-base font-semibold text-gray-800">Booking Terbaru</h4>
                        <p class="text-xs text-gray-500 mt-1">Daftar booking yang baru masuk</p>
                    </div>
                    <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center gap-1 px-3 py-2 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 transition-colors">
                        Lihat Semua
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentBookings as $booking)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 flex-1">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 text-lg">
                                    ⚽
                                </div>
                                <div class="flex-1">
                                    <h5 class="font-medium text-gray-800 text-sm">{{ optional($booking->service)->name ?? 'Service' }}</h5>
                                    <div class="flex items-center gap-3 text-xs text-gray-500 mt-1">
                                        <span>{{ $booking->booking_code ?? '#'.$booking->id }}</span>
                                        <span>•</span>
                                        <span>{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}</span>
                                        <span>•</span>
                                        <span>{{ substr($booking->start_time ?? '00:00',0,5) }} - {{ substr($booking->end_time ?? '00:00',0,5) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right flex items-center gap-3">
                                <div class="text-sm font-semibold text-green-600">
                                    Rp {{ number_format(optional($booking->payment)->amount ?? (optional($booking->service)->price ?? 0), 0, ',', '.') }}
                                </div>
                                @php
                                    $statusConfig = [
                                        'pending' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'label' => 'Pending'],
                                        'confirmed' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'Terkonfirmasi'],
                                        'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Selesai'],
                                        'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Dibatalkan'],
                                    ];
                                    $status = $booking->status ?? 'pending';
                                    $config = $statusConfig[$status] ?? $statusConfig['pending'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 {{ $config['bg'] }} {{ $config['text'] }} text-xs font-medium rounded">
                                    {{ $config['label'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p class="text-gray-500 text-sm font-medium">Belum ada booking</p>
                        <p class="text-xs text-gray-400 mt-1">Booking baru akan muncul di sini</p>
                    </div>
                @endforelse
            </div>
        </div>
@endsection
