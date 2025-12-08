@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Selamat datang, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-gray-600 mt-2">Kelola booking Anda dengan mudah</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Booking Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $activeBookings->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Selesai</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $completedCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-amber-100 rounded-lg p-3">
                        <svg class="h-8 w-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Pending</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $pendingCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Bookings -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-900">Booking Aktif</h2>
                <a href="{{ route('my.bookings') }}" class="text-blue-600 hover:text-blue-700">Lihat Semua →</a>
            </div>

            @forelse($activeBookings as $booking)
                <div class="border border-gray-200 rounded-lg p-4 mb-4 hover:border-blue-500 transition">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $booking->service->name }}</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                📅 {{ $booking->slot->date->format('d F Y') }} • 
                                🕐 {{ $booking->slot->start_time }} - {{ $booking->slot->end_time }}
                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                Kode: <span class="font-mono font-semibold">{{ $booking->booking_code }}</span>
                            </p>
                            <div class="mt-2">
                                @if($booking->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        ⏳ Pending
                                    </span>
                                @elseif($booking->status === 'confirmed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        ✓ Confirmed
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-2 ml-4">
                            <a href="{{ route('booking.details', $booking->id) }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                                Detail
                            </a>
                            @if($booking->status === 'pending')
                                <form method="POST" action="{{ route('booking.cancel', $booking->id) }}" 
                                      onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                    @csrf
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition text-sm">
                                        Cancel
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-600">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="mt-4">Belum ada booking aktif</p>
                </div>
            @endforelse
        </div>

        <!-- CTA Button -->
        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                ➕ Buat Booking Baru
            </a>
        </div>
    </div>
</div>
@endsection
