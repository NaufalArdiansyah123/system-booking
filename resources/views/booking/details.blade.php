@extends('layouts.app')

@section('title', 'Booking Details')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        <div class="bg-green-50 border-l-4 border-green-500 p-6 mb-8 rounded-lg">
            <div class="flex items-center">
                <svg class="h-8 w-8 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h3 class="text-lg font-bold text-green-900">Booking Berhasil Dibuat! 🎉</h3>
                    <p class="text-green-700 text-sm mt-1">Booking Anda telah tersimpan. Silakan simpan kode booking Anda.</p>
                </div>
            </div>
        </div>

        <!-- Booking Details Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-8 text-white text-center">
                <h1 class="text-3xl font-bold mb-2">Booking Details</h1>
                <p class="text-blue-100">Simpan kode booking Anda dengan baik</p>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Booking Code -->
                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6 mb-6 text-center">
                    <p class="text-sm text-blue-600 font-semibold mb-2">KODE BOOKING</p>
                    <p class="text-4xl font-bold text-blue-900 tracking-wider">{{ $booking->booking_code }}</p>
                </div>

                <!-- Status Badge -->
                <div class="flex justify-center mb-8">
                    @if($booking->status === 'pending')
                        <span class="inline-flex items-center px-6 py-2 rounded-full text-lg font-semibold bg-amber-100 text-amber-800">
                            <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            Menunggu Konfirmasi
                        </span>
                    @elseif($booking->status === 'confirmed')
                        <span class="inline-flex items-center px-6 py-2 rounded-full text-lg font-semibold bg-green-100 text-green-800">
                            <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Booking Dikonfirmasi
                        </span>
                    @elseif($booking->status === 'cancelled')
                        <span class="inline-flex items-center px-6 py-2 rounded-full text-lg font-semibold bg-red-100 text-red-800">
                            Dibatalkan
                        </span>
                    @elseif($booking->status === 'completed')
                        <span class="inline-flex items-center px-6 py-2 rounded-full text-lg font-semibold bg-gray-100 text-gray-800">
                            Selesai
                        </span>
                    @endif
                </div>

                <!-- QR Code -->
                @if($booking->status !== 'cancelled')
                    <div class="bg-gray-50 rounded-lg p-6 mb-6 text-center">
                        <p class="text-sm text-gray-600 mb-4">Scan QR Code untuk akses cepat</p>
                        <div class="inline-block bg-white p-4 rounded-lg shadow-md">
                            <img src="{{ route('booking.qrcode', $booking->id) }}" alt="QR Code" class="w-48 h-48 mx-auto">
                        </div>
                    </div>
                @endif

                <!-- Booking Info -->
                <div class="space-y-4 border-t border-gray-200 pt-6">
                    <div class="flex items-start">
                        <svg class="h-6 w-6 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Layanan</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $booking->service->name }}</p>
                            <p class="text-sm text-gray-600">{{ $booking->service->description }}</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="h-6 w-6 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal & Waktu</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $booking->slot->date->format('l, d F Y') }}
                            </p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $booking->slot->start_time }} - {{ $booking->slot->end_time }} WIB
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="h-6 w-6 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Lokasi</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $booking->service->location }}</p>
                        </div>
                    </div>

                    @if($booking->note)
                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Catatan</p>
                                <p class="text-gray-900">{{ $booking->note }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-start">
                        <svg class="h-6 w-6 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500">Pembayaran</p>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-lg font-semibold text-gray-900">{{ ucfirst($booking->payment->method) }}</p>
                                    @if($booking->payment->status === 'success')
                                        <span class="text-sm text-green-600 font-medium">✓ Sudah Dibayar</span>
                                    @else
                                        <span class="text-sm text-amber-600 font-medium">Menunggu Pembayaran</span>
                                    @endif
                                </div>
                                <p class="text-2xl font-bold text-blue-600">
                                    Rp {{ number_format($booking->payment->amount, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('dashboard') }}" 
                       class="flex-1 bg-blue-600 text-white text-center py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                        📊 Ke Dashboard
                    </a>
                    <a href="{{ route('home') }}" 
                       class="flex-1 bg-gray-200 text-gray-700 text-center py-3 rounded-lg hover:bg-gray-300 transition font-semibold">
                        🏠 Ke Beranda
                    </a>
                </div>

                @if($booking->status === 'pending')
                    <div class="mt-4 bg-amber-50 border border-amber-200 rounded-lg p-4">
                        <p class="text-sm text-amber-800">
                            <svg class="inline h-5 w-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <strong>Perhatian:</strong> Booking Anda akan expire dalam {{ $booking->expires_at ? $booking->expires_at->diffForHumans() : '2 jam' }} jika tidak dikonfirmasi oleh admin.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
