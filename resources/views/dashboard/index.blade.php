@extends('layouts.app')

@section('title', 'Booking Saya')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Booking Saya 📋</h1>
            <p class="text-gray-600 mt-2">Kelola dan lihat semua booking aktif Anda</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 font-medium">Booking Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $activeBookings->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 font-medium">Selesai</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $completedCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-amber-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-amber-100 rounded-lg p-3">
                        <svg class="h-8 w-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 font-medium">Pending</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $pendingCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- All Active Bookings -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white">Semua Booking Aktif</h2>
                    <a href="{{ route('services') }}" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition text-sm font-semibold backdrop-blur-sm">
                        + Buat Booking Baru
                    </a>
                </div>
            </div>

            <div class="p-6">
                @forelse($activeBookings as $booking)
                    <div class="border-2 border-gray-200 rounded-xl p-6 mb-4 hover:border-green-500 hover:shadow-lg transition-all duration-200">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <!-- Left Section - Booking Details -->
                            <div class="flex-1">
                                <div class="flex items-start gap-4">
                                    <!-- Icon -->
                                    <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                        </svg>
                                    </div>

                                    <!-- Details -->
                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $booking->service->name }}</h3>
                                        
                                        <div class="grid sm:grid-cols-2 gap-2 text-sm">
                                            <div class="flex items-center text-gray-600">
                                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <span class="font-medium">{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</span>
                                            </div>
                                            
                                            <div class="flex items-center text-gray-600">
                                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span class="font-medium">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</span>
                                            </div>
                                        </div>

                                        <div class="mt-3 flex items-center gap-3">
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                                </svg>
                                                <span class="font-mono font-semibold text-gray-900">{{ $booking->booking_code }}</span>
                                            </div>

                                            @if($booking->status === 'pending')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Menunggu Pembayaran
                                                </span>
                                            @elseif($booking->status === 'confirmed')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Terkonfirmasi
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Price -->
                                        <div class="mt-3 pt-3 border-t border-gray-200">
                                            <div class="flex items-baseline gap-2">
                                                <span class="text-sm text-gray-500">Total Pembayaran:</span>
                                                @php
                                                    // Prefer recorded payment amount when available and > 0,
                                                    // otherwise fallback to service price (legacy bookings).
                                                    $recorded = optional($booking->payment)->amount;
                                                    $paidAmount = (is_numeric($recorded) && $recorded > 0) ? $recorded : (optional($booking->service)->price ?? 0);
                                                @endphp
                                                <span class="text-xl font-bold text-green-600">Rp {{ number_format($paidAmount, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Section - Actions -->
                            <div class="flex lg:flex-col gap-2 pt-4 lg:pt-0 border-t lg:border-t-0 lg:border-l lg:pl-6 border-gray-200">
                                @if($booking->status === 'pending' && $booking->snap_token)
                                    <button onclick="payNow('{{ $booking->snap_token }}')" 
                                           class="flex-1 lg:flex-none bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2.5 rounded-lg hover:from-blue-700 hover:to-blue-800 transition text-sm font-semibold shadow-lg shadow-blue-500/30 whitespace-nowrap">
                                        💳 Bayar Sekarang
                                    </button>
                                @endif
                                
                                <a href="{{ route('booking.details', $booking->id) }}" 
                                   class="flex-1 lg:flex-none bg-white border-2 border-gray-300 text-gray-700 px-6 py-2.5 rounded-lg hover:border-green-500 hover:text-green-600 transition text-sm font-semibold text-center whitespace-nowrap">
                                    📄 Detail
                                </a>
                                
                                @if($booking->status === 'pending')
                                    <form method="POST" action="{{ route('booking.cancel', $booking->id) }}" 
                                          onsubmit="return confirm('Yakin ingin membatalkan booking ini?')"
                                          class="flex-1 lg:flex-none">
                                        @csrf
                                        <button type="submit" class="w-full bg-red-50 border-2 border-red-200 text-red-600 px-6 py-2.5 rounded-lg hover:bg-red-100 hover:border-red-300 transition text-sm font-semibold whitespace-nowrap">
                                            ✕ Batalkan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada booking aktif</h3>
                        <p class="text-gray-600 mb-6">Mulai booking lapangan futsal favorit Anda sekarang!</p>
                        <a href="{{ route('services') }}" class="inline-flex items-center bg-gradient-to-r from-green-600 to-green-700 text-white px-8 py-3 rounded-xl hover:from-green-700 hover:to-green-800 transition font-semibold shadow-lg shadow-green-500/30">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Buat Booking Baru
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    function payNow(snapToken) {
        if (!snapToken) {
            alert('Token pembayaran tidak tersedia');
            return;
        }
        
        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                console.log('Payment success:', result);
                alert('Pembayaran berhasil!');
                window.location.reload();
            },
            onPending: function(result) {
                console.log('Payment pending:', result);
                alert('Menunggu pembayaran. Silakan selesaikan pembayaran Anda.');
                window.location.reload();
            },
            onError: function(result) {
                console.log('Payment error:', result);
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function() {
                console.log('Payment popup closed');
            }
        });
    }
</script>
@endpush
