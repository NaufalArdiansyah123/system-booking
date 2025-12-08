@extends('layouts.app')

@section('title', $service->name ?? 'Detail Lapangan')

@push('styles')
<style>
    /* Hide elements with x-cloak until Alpine is ready */
    [x-cloak] {
        display: none !important;
    }
    
    /* Force hide AM/PM in time inputs */
    input[type="time"]::-webkit-datetime-edit-ampm-field {
        display: none !important;
        width: 0 !important;
        opacity: 0 !important;
        visibility: hidden !important;
    }
    input[type="time"]::-webkit-calendar-picker-indicator {
        filter: invert(0.5);
    }
</style>
@endpush

@push('scripts')
<!-- Midtrans Snap Script -->
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key', 'YOUR-CLIENT-KEY') }}"></script>

<script>
    // Remove AM/PM text from time inputs
    document.addEventListener('DOMContentLoaded', function() {
        const timeInputs = document.querySelectorAll('input[type="time"]');
        timeInputs.forEach(input => {
            // Force 24 hour format
            input.addEventListener('input', function(e) {
                let value = e.target.value;
                if (value) {
                    // Ensure format is HH:MM without AM/PM
                    const parts = value.match(/(\d{1,2}):(\d{2})/);
                    if (parts) {
                        let hours = parseInt(parts[1]);
                        let minutes = parts[2];
                        e.target.value = `${hours.toString().padStart(2, '0')}:${minutes}`;
                    }
                }
            });
        });
    });
</script>
@endpush

@section('content')

    <div x-data="serviceDetail()" @keydown.window.escape="featuresOpen = false; calendarOpen = false; timeModalOpen = false">

        <!-- Hero -->
        <section class="relative bg-gradient-to-br from-green-600 via-green-700 to-green-900 text-white overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60"
                    viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg
                    fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath
                    d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"
                    /%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-white text-sm font-semibold">Detail
                            Lapangan</span>
                        <h1 class="text-4xl md:text-5xl font-extrabold text-white mt-4">{{ $service->name ?? 'Lapangan' }}
                        </h1>
                        <p class="text-lg text-green-100 mt-4 max-w-xl">
                            {{ $service->short_description ?? ($service->description ?? 'Detail lapangan futsal dan fasilitasnya') }}
                        </p>

                        <div class="flex gap-4 mt-6">
                            <a href="{{ route('services') }}"
                                class="inline-flex items-center gap-3 bg-white/20 text-white px-5 py-3 rounded-lg">Kembali</a>
                            <button @click.prevent="openCalendar()"
                                class="inline-flex items-center gap-3 bg-yellow-400 text-gray-900 px-5 py-3 rounded-lg font-semibold">Cari
                                Jadwal</button>
                        </div>
                    </div>

                    <div class="hidden md:block">
                        <div class="relative bg-white/10 rounded-3xl p-6 border-4 border-white/20 shadow-2xl">
                            <svg class="w-full h-56" viewBox="0 0 400 300" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect x="50" y="50" width="300" height="200" rx="10" fill="#10B981"
                                    stroke="#fff" stroke-width="3" />
                                <line x1="200" y1="50" x2="200" y2="250" stroke="#fff"
                                    stroke-width="3" />
                                <circle cx="200" cy="150" r="36" stroke="#fff" stroke-width="3"
                                    fill="none" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Detail Section -->
        <section class="py-12 bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Left: Gallery / Images -->
                    <div class="md:col-span-2">
                        <div class="rounded-2xl overflow-hidden shadow-lg mb-6">
                            <img src="{{ $service->image_url ?? asset('images/field-placeholder.jpg') }}"
                                alt="{{ $service->name }}" class="w-full h-96 object-cover">
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <img src="{{ $service->image_url ?? asset('images/field-placeholder.jpg') }}" alt="thumb"
                                class="w-full h-24 object-cover rounded-lg">
                            <img src="{{ $service->image_url ?? asset('images/field-placeholder.jpg') }}" alt="thumb"
                                class="w-full h-24 object-cover rounded-lg">
                            <img src="{{ $service->image_url ?? asset('images/field-placeholder.jpg') }}" alt="thumb"
                                class="w-full h-24 object-cover rounded-lg">
                        </div>

                        <div class="mt-8 prose max-w-none text-gray-700">
                            <h3>Deskripsi</h3>
                            <p>{{ $service->description ?? 'Deskripsi lapangan tidak tersedia.' }}</p>

                            <h4 class="mt-6">Fitur & Fasilitas</h4>
                            <ul class="list-disc ml-6">
                                <li>Lantai: {{ $service->floor_type ?? 'Vinyl / Rumput Sintetis' }}</li>
                                <li>Pencahayaan LED</li>
                                <li>Ruang ganti ber-AC & shower</li>
                                <li>Area parkir & kantin</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Right: Booking summary -->
                    <aside
                        class="p-6 bg-gradient-to-br from-gray-50 to-white rounded-2xl shadow-lg border-2 border-gray-100">
                        <div class="mb-6 text-center">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-50 rounded-full mb-4">
                                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900">{{ $service->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $service->location ?? 'Lokasi tersedia' }}</p>
                        </div>

                        <div class="mb-6">
                            <div class="flex items-baseline justify-between">
                                <div class="text-sm text-gray-600">Harga</div>
                                <div class="text-2xl font-bold text-green-600">Rp
                                    {{ number_format($service->price ?? 0, 0, ',', '.') }}</div>
                            </div>
                            <div class="text-sm text-gray-500">/ jam &middot; Durasi: {{ $service->duration ?? 60 }} menit
                            </div>
                        </div>

                        <div class="space-y-4">
                            <button @click.prevent="openCalendar()"
                                class="block w-full text-center bg-gradient-to-r from-green-600 to-green-700 text-white py-3 rounded-xl font-bold">Cari
                                Jadwal</button>
                            <button @click.prevent="featuresOpen = true"
                                class="block w-full text-center border border-gray-200 py-3 rounded-xl font-semibold">Lihat
                                Fitur Lengkap</button>
                        </div>

                        <div class="mt-6 text-sm text-gray-500">
                            <p><strong>Catatan:</strong> Untuk memesan, gunakan tombol "Cari Jadwal" untuk melihat slot
                                tersedia.</p>
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        <!-- Similar CTA as other pages -->
        {{-- <section class="bg-gradient-to-r from-green-600 to-green-800 text-white py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h3 class="text-2xl font-bold mb-4">Ingin Memesan Sekarang?</h3>
                <p class="text-green-100 mb-6">Klik tombol di bawah untuk melihat jadwal dan lanjutkan ke preview booking.
                </p>
                <a href="{{ route('services') }}?service={{ $service->id }}#search"
                    class="inline-flex items-center gap-3 bg-yellow-400 text-gray-900 px-6 py-3 rounded-lg font-semibold">🔎
                    Lihat Jadwal & Booking</a>
            </div>
        </section> --}}

        <!-- Calendar Modal -->
        <div x-show="calendarOpen" x-cloak x-transition.opacity
            class="fixed inset-0 z-40 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/60" @click="calendarOpen = false"></div>
            <div
                class="relative max-w-2xl w-full bg-white rounded-3xl shadow-2xl transform transition-all duration-200 scale-100">
                <div class="flex items-center justify-between p-4 border-b">
                    <div class="flex items-center gap-3">
                        <button @click="prevMonth()"
                            class="px-3 py-2 rounded-md bg-gray-100 hover:bg-gray-200 text-lg">‹</button>
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Bulan</div>
                            <div class="font-semibold text-base"><span
                                    x-text="new Date(currentYear, currentMonth-1).toLocaleString('default', { month: 'long' })"></span>&nbsp;<span
                                    x-text="currentYear"></span></div>
                        </div>
                        <button @click="nextMonth()"
                            class="px-3 py-2 rounded-md bg-gray-100 hover:bg-gray-200 text-lg">›</button>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-sm text-gray-600">Legenda:</div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-gray-300 rounded-full border"></div>
                            <div class="text-sm text-gray-600">Penuh</div>
                        </div>
                        <button @click="calendarOpen = false"
                            class="ml-4 px-3 py-2 rounded-md text-sm text-gray-600 hover:bg-gray-50">Tutup</button>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-7 gap-2 text-center text-xs text-gray-600 mb-3 uppercase tracking-wider">
                        <div>Sun</div>
                        <div>Mon</div>
                        <div>Tue</div>
                        <div>Wed</div>
                        <div>Thu</div>
                        <div>Fri</div>
                        <div>Sat</div>
                    </div>

                    <div class="grid grid-cols-7 gap-2">
                        <template x-for="day in daysArray()" :key="day.dateStr">
                            <div class="h-14 flex items-center justify-center">
                                <div class="relative">
                                    <button
                                        :class="{
                                            'text-gray-400': !day.inMonth,
                                            'text-gray-900 bg-white hover:bg-green-50': day.inMonth && !isFull(day
                                                .dateStr),
                                            'text-gray-500': day.inMonth && isFull(day.dateStr)
                                        }"
                                        class="w-10 h-10 rounded-full flex items-center justify-center transition"
                                        x-text="day.day" @click="if(day.inMonth){ openDay(day.dateStr) }"></button>

                                    <!-- overlay for full day -->
                                    <div x-show="isFull(day.dateStr) && day.inMonth"
                                        class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <div class="w-10 h-10 rounded-full bg-gray-300 opacity-85"></div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Time Selection Modal -->
        <div x-show="timeModalOpen" x-cloak x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/60" @click="timeModalOpen = false"></div>
            <div class="relative max-w-xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="flex items-center justify-between p-6 border-b">
                    <div>
                        <h3 class="text-lg font-bold">Pilih Jam Booking</h3>
                        <div class="text-sm text-gray-500"><span class="font-semibold"
                                x-text="formatSelectedDate()"></span></div>
                    </div>
                    <div>
                        <button @click="timeModalOpen = false" class="text-gray-600 hover:text-gray-800">✕</button>
                    </div>
                </div>

                <div class="p-6 max-h-[70vh] overflow-y-auto">
                    <form @submit.prevent="confirmBooking()">
                        <div class="space-y-4">
                            <!-- Jam Mulai -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Mulai</label>
                                <input type="text" x-model="startTime" required
                                    class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    placeholder="08:00"
                                    maxlength="5"
                                    @input="formatTimeInput($event, 'start')"
                                    pattern="([0-1][0-9]|2[0-2]):[0-5][0-9]">
                                <p class="text-xs text-gray-500 mt-1">Contoh: 08:00, 13:00, 20:00 (format 24 jam)</p>
                            </div>

                            <!-- Jam Selesai -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Selesai</label>
                                <input type="text" x-model="endTime" required
                                    class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    placeholder="10:00"
                                    maxlength="5"
                                    @input="formatTimeInput($event, 'end')"
                                    pattern="([0-1][0-9]|2[0-2]):[0-5][0-9]">
                                <p class="text-xs text-gray-500 mt-1">Contoh: 10:00, 15:00, 22:00 (format 24 jam)</p>
                                <p x-show="startTime && endTime && startTime >= endTime" class="text-sm text-red-600 mt-1">Jam selesai harus lebih besar dari jam mulai</p>
                            </div>
                        </div>

                        <!-- Jam yang sudah dibooking -->
                        <div class="mt-6">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Jam yang Sudah Dibooking:</h4>
                            <div class="space-y-2 max-h-48 overflow-y-auto">
                                <template x-if="bookedRanges.length > 0">
                                    <template x-for="(range, idx) in bookedRanges" :key="idx">
                                        <div class="flex items-center justify-between p-3 rounded-lg bg-red-50 border border-red-200">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="text-sm font-medium text-gray-800" x-text="range"></span>
                                            </div>
                                            <span class="text-xs text-red-600 font-semibold">TIDAK TERSEDIA</span>
                                        </div>
                                    </template>
                                </template>
                                <template x-if="bookedRanges.length === 0">
                                    <div class="text-sm text-gray-500 p-3 bg-gray-50 rounded-lg text-center">Belum ada booking untuk hari ini</div>
                                </template>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" @click="timeModalOpen = false"
                                class="px-5 py-2.5 rounded-lg border-2 border-gray-300 font-semibold hover:bg-gray-50">Batal</button>
                            <button type="submit" :disabled="!startTime || !endTime || startTime >= endTime"
                                class="px-5 py-2.5 rounded-lg bg-green-600 text-white font-semibold disabled:opacity-50 hover:bg-green-700">
                                Lanjutkan Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Confirmation Modal -->
        <div x-show="confirmModalOpen" x-cloak x-transition.opacity
            class="fixed inset-0 z-[60] flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/70" @click="confirmModalOpen = false"></div>
            <div class="relative max-w-lg w-full bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 p-6 text-white">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Konfirmasi Booking</h3>
                            <p class="text-green-100 text-sm">Periksa detail booking Anda</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Lapangan -->
                        <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg">
                            <svg class="w-5 h-5 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                            </svg>
                            <div class="flex-1">
                                <div class="text-xs text-gray-500 mb-1">Lapangan</div>
                                <div class="font-bold text-gray-900">{{ $service->name }}</div>
                            </div>
                        </div>

                        <!-- Tanggal -->
                        <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg">
                            <svg class="w-5 h-5 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            <div class="flex-1">
                                <div class="text-xs text-gray-500 mb-1">Tanggal Booking</div>
                                <div class="font-bold text-gray-900" x-text="formatSelectedDate()"></div>
                            </div>
                        </div>

                        <!-- Waktu -->
                        <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg">
                            <svg class="w-5 h-5 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            <div class="flex-1">
                                <div class="text-xs text-gray-500 mb-1">Jam Main</div>
                                <div class="font-bold text-gray-900">
                                    <span x-text="startTime"></span> - <span x-text="endTime"></span>
                                    <span class="text-sm text-gray-600">(<span x-text="calculateDuration()"></span> jam)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Harga -->
                        <div class="flex items-start gap-3 p-4 bg-green-50 rounded-lg border-2 border-green-200">
                            <svg class="w-5 h-5 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                            <div class="flex-1">
                                <div class="text-xs text-gray-600 mb-1">Estimasi Total</div>
                                <div class="font-bold text-green-700 text-xl">
                                    Rp <span x-text="calculateTotal().toLocaleString('id-ID')"></span>
                                </div>
                                <div class="text-xs text-gray-600 mt-1">
                                    Rp {{ number_format($service->price ?? 0, 0, ',', '.') }} × <span x-text="calculateDuration()"></span> jam
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex gap-2">
                            <svg class="w-5 h-5 text-yellow-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-sm text-yellow-800">
                                <div class="font-semibold mb-1">Perhatian:</div>
                                <div>Pastikan waktu booking Anda sudah benar. Pembayaran akan dilakukan setelah konfirmasi.</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="button" @click="confirmModalOpen = false; timeModalOpen = true"
                            class="flex-1 px-5 py-3 rounded-lg border-2 border-gray-300 font-semibold hover:bg-gray-50 transition">
                            Ubah Waktu
                        </button>
                        <button type="button" @click="proceedToBooking()"
                            class="flex-1 px-5 py-3 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700 transition">
                            Konfirmasi & Lanjutkan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Method Modal -->
        <div x-show="paymentModalOpen" x-cloak x-transition.opacity
            class="fixed inset-0 z-[70] flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/70" @click="paymentModalOpen = false"></div>
            <div class="relative max-w-lg w-full bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6 text-white">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Metode Pembayaran</h3>
                            <p class="text-blue-100 text-sm">Pilih metode pembayaran</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Summary -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Total Pembayaran</span>
                            <span class="text-2xl font-bold text-gray-900">
                                Rp <span x-text="calculateTotal().toLocaleString('id-ID')"></span>
                            </span>
                        </div>
                        <div class="text-sm text-gray-500">
                            <span x-text="formatSelectedDate()"></span> • 
                            <span x-text="startTime"></span> - <span x-text="endTime"></span>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <div class="space-y-3 mb-6">
                        <div class="text-sm font-semibold text-gray-700 mb-3">Pilih Metode Pembayaran:</div>
                        
                        <!-- QRIS -->
                        <label class="flex items-center gap-4 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition"
                            :class="{ 'border-blue-500 bg-blue-50': paymentMethod === 'qris' }">
                            <input type="radio" name="payment" value="qris" x-model="paymentMethod" class="w-5 h-5 text-blue-600">
                            <div class="flex-1">
                                <div class="font-semibold text-gray-900">QRIS</div>
                                <div class="text-xs text-gray-500 mt-1">Scan & bayar dengan QRIS dari semua e-wallet & bank</div>
                            </div>
                            <svg class="w-10 h-10 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 11h8V3H3v8zm2-6h4v4H5V5zm-2 14h8v-8H3v8zm2-6h4v4H5v-4zm8-10v8h8V3h-8zm6 6h-4V5h4v4zm-6 4h2v2h-2v-2zm2 2h2v2h-2v-2zm-2 2h2v2h-2v-2zm4 0h2v2h-2v-2zm2-2h2v2h-2v-2zm0-4h2v2h-2v-2zm-4 0h2v2h-2v-2z"/>
                            </svg>
                        </label>

                        <!-- Transfer Bank -->
                        <label class="flex items-center gap-4 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-500 transition"
                            :class="{ 'border-green-500 bg-green-50': paymentMethod === 'bank_transfer' }">
                            <input type="radio" name="payment" value="bank_transfer" x-model="paymentMethod" class="w-5 h-5 text-green-600">
                            <div class="flex-1">
                                <div class="font-semibold text-gray-900">Transfer Bank</div>
                                <div class="text-xs text-gray-500 mt-1">BCA, Mandiri, BNI, BRI, Permata</div>
                            </div>
                            <svg class="w-10 h-10 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                            </svg>
                        </label>

                        <!-- E-Wallet -->
                        <label class="flex items-center gap-4 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-500 transition"
                            :class="{ 'border-purple-500 bg-purple-50': paymentMethod === 'ewallet' }">
                            <input type="radio" name="payment" value="ewallet" x-model="paymentMethod" class="w-5 h-5 text-purple-600">
                            <div class="flex-1">
                                <div class="font-semibold text-gray-900">E-Wallet</div>
                                <div class="text-xs text-gray-500 mt-1">GoPay, ShopeePay, OVO, DANA</div>
                            </div>
                            <svg class="w-10 h-10 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                        </label>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="button" @click="paymentModalOpen = false; confirmModalOpen = true"
                            class="flex-1 px-5 py-3 rounded-lg border-2 border-gray-300 font-semibold hover:bg-gray-50 transition">
                            Kembali
                        </button>
                        <button type="button" @click="processPayment()"
                            :disabled="!paymentMethod"
                            class="flex-1 px-5 py-3 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition">
                            <span x-show="!paymentLoading">Bayar Sekarang</span>
                            <span x-show="paymentLoading" class="flex items-center justify-center gap-2">
                                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Modal -->
        <div x-show="featuresOpen" x-cloak x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/60" @click="featuresOpen = false"></div>
            <div class="relative max-w-3xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="flex items-center justify-between p-6 border-b">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Fitur & Fasilitas</h3>
                            <div class="text-sm text-gray-500">{{ $service->name }}</div>
                        </div>
                    </div>
                    <button @click="featuresOpen = false" class="text-gray-500 hover:text-gray-700">✕</button>
                </div>

                <div class="p-6 max-h-[65vh] overflow-y-auto">
                    @php
                        $featuresList = null;
                        if (!empty($service->features)) {
                            $decoded = json_decode($service->features, true);
                            if (is_array($decoded)) {
                                $featuresList = $decoded;
                            }
                        }
                    @endphp

                    @if ($featuresList && count($featuresList))
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach ($featuresList as $feat)
                                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="w-10 h-10 bg-green-100 rounded-md flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 2h16v16H2z" opacity=".05" />
                                        </svg>
                                    </div>
                                    <div class="text-sm text-gray-700">{{ $feat }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-3">
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="font-semibold">Lantai</div>
                                <div class="text-sm text-gray-600">{{ $service->floor_type ?? 'Vinyl / Rumput Sintetis' }}
                                </div>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="font-semibold">Pencahayaan</div>
                                <div class="text-sm text-gray-600">LED berkualitas</div>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="font-semibold">Ruang Ganti</div>
                                <div class="text-sm text-gray-600">AC, shower, loker</div>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="font-semibold">Parkir</div>
                                <div class="text-sm text-gray-600">Area parkir luas dan aman</div>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="font-semibold">Kantin</div>
                                <div class="text-sm text-gray-600">Makanan & minuman ringan tersedia</div>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="font-semibold">Sound System</div>
                                <div class="text-sm text-gray-600">Tersedia (lapangan VIP)</div>
                            </div>
                        </div>
                    @endif

                <!-- Success Modal -->
                <div x-show="successModalOpen" x-cloak x-transition.opacity class="fixed inset-0 z-[80] flex items-center justify-center px-4">
                    <div class="absolute inset-0 bg-black/70" @click="successModalOpen = false"></div>
                    <div class="relative max-w-md w-full bg-white rounded-3xl shadow-2xl overflow-hidden">
                        <div class="p-6 text-center">
                            <div class="w-20 h-20 mx-auto flex items-center justify-center rounded-full bg-green-100 mb-4">
                                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Pembayaran Berhasil</h3>
                            <p class="text-sm text-gray-600 mt-2">Terima kasih! Pembayaran Anda telah diterima.</p>

                            <div class="mt-4 p-4 bg-gray-50 rounded-lg text-left">
                                <div class="text-xs text-gray-500">Order ID</div>
                                <div class="font-semibold text-gray-800 break-all" x-text="successInfo.order_id || '-'"></div>

                                <div class="mt-3 text-xs text-gray-500">Jumlah</div>
                                <div class="font-semibold text-gray-800">Rp <span x-text="(successInfo.amount || 0).toLocaleString('id-ID')"></span></div>
                            </div>

                            <div class="mt-6 flex gap-3">
                                <button @click="successModalOpen = false; window.location = '/'" class="flex-1 px-4 py-2 rounded-lg border">Tutup</button>
                                <button @click="successModalOpen = false; window.location = '/booking/success/' + (successInfo.order_id || '')" class="flex-1 px-4 py-2 rounded-lg bg-green-600 text-white">Lihat Booking</button>
                            </div>
                        </div>
                    </div>
                </div>

                    @if (!empty($service->notes))
                        <div class="mt-4 text-sm text-gray-600">
                            <strong>Catatan:</strong>
                            <p>{{ $service->notes }}</p>
                        </div>
                    @endif
                </div>

                <div class="p-6 border-t flex justify-end gap-3">
                    <button @click="featuresOpen = false" class="px-4 py-2 rounded-lg border">Tutup</button>
                    <a href="{{ route('services') }}?service={{ $service->id }}#search"
                        class="px-4 py-2 rounded-lg bg-green-600 text-white font-semibold">Cari Jadwal</a>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        function serviceDetail() {
            return {
                featuresOpen: false,
                calendarOpen: false,
                timeModalOpen: false,
                confirmModalOpen: false,
                paymentModalOpen: false,
                availability: {},
                currentYear: new Date().getFullYear(),
                currentMonth: new Date().getMonth() + 1,
                serviceId: {{ (int) $service->id }},
                loadingMonth: false,
                pricePerHour: {{ (int) ($service->price ?? 0) }},
                paymentMethod: null,
                paymentLoading: false,
                // Success modal state
                successModalOpen: false,
                successInfo: {},

                async loadMonth(year = this.currentYear, month = this.currentMonth) {
                    this.loadingMonth = true;
                    try {
                        const res = await fetch('{{ route('service.availability') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                service_id: this.serviceId,
                                year: year,
                                month: month
                            })
                        });
                        const data = await res.json();
                        if (data.success) {
                            this.currentYear = data.year;
                            this.currentMonth = data.month;
                            this.availability = data.availability || {};
                        }
                    } catch (e) {
                        console.error(e);
                    } finally {
                        this.loadingMonth = false;
                    }
                },

                daysArray() {
                    const year = this.currentYear;
                    const month = this.currentMonth;
                    const first = new Date(year, month - 1, 1);
                    const firstDay = first.getDay();
                    const total = new Date(year, month, 0).getDate();
                    const prevTotal = new Date(year, month - 1, 0).getDate();

                    const arr = [];
                    // Helper to format date as YYYY-MM-DD in local time
                    const formatLocalDate = (y, m, d) => {
                        return y + '-' + String(m).padStart(2, '0') + '-' + String(d).padStart(2, '0');
                    };

                    // leading days from prev month
                    for (let i = firstDay; i > 0; i--) {
                        const dayNum = prevTotal - i + 1;
                        arr.push({
                            day: dayNum,
                            inMonth: false,
                            dateStr: formatLocalDate(year, month - 1, dayNum)
                        });
                    }

                    // current month days
                    for (let d = 1; d <= total; d++) {
                        arr.push({
                            day: d,
                            inMonth: true,
                            dateStr: formatLocalDate(year, month, d)
                        });
                    }

                    // trailing days to fill to 7*n
                    while (arr.length % 7 !== 0) {
                        const next = arr.length - (firstDay + total) + 1;
                        arr.push({
                            day: next,
                            inMonth: false,
                            dateStr: formatLocalDate(year, month + 1, next)
                        });
                    }

                    return arr;
                },

                isFull(dateStr) {
                    return Object.prototype.hasOwnProperty.call(this.availability, dateStr) && this.availability[
                        dateStr] === 0;
                },

                openCalendar() {
                    this.calendarOpen = true;
                    this.loadMonth();
                },

                // day / time slots
                selectedDate: null,
                daySlots: {},
                slotsLoading: false,
                startTime: null,
                endTime: null,
                
                get bookedRanges() {
                    // Return each booked slot as its own range (do not merge contiguous hours)
                    const ranges = [];
                    const sortedKeys = Object.keys(this.daySlots).sort();

                    for (const key of sortedKeys) {
                        const slot = this.daySlots[key];
                        if (slot.is_full || slot.booked > 0) {
                            const hour = parseInt(key.split(':')[0]);
                            const end = String(hour + 1).padStart(2, '0') + ':00';
                            ranges.push(key + ' - ' + end);
                        }
                    }

                    return ranges;
                },

                async openDay(dateStr) {
                    this.slotsLoading = true;
                    this.startTime = null;
                    this.endTime = null;
                    try {
                        const res = await fetch('{{ route('service.day.slots') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                service_id: this.serviceId,
                                date: dateStr
                            })
                        });
                        const data = await res.json();
                        if (data.success) {
                            this.selectedDate = data.date;
                            // map slots by HH:MM
                            this.daySlots = {};
                            data.slots.forEach(s => {
                                const k = s.start_time.slice(0, 5);
                                this.daySlots[k] = s;
                            });
                            // close calendar and open slots modal
                            this.calendarOpen = false;
                            this.timeModalOpen = true;
                        }
                    } catch (e) {
                        console.error(e);
                    } finally {
                        this.slotsLoading = false;
                    }
                },

                confirmBooking() {
                    if (!this.startTime || !this.endTime || this.startTime >= this.endTime) {
                        alert('Mohon pilih jam mulai dan jam selesai yang valid');
                        return;
                    }
                    
                    // Check for conflicts with booked ranges
                    const start = parseInt(this.startTime.split(':')[0]);
                    const end = parseInt(this.endTime.split(':')[0]);
                    
                    for (const range of this.bookedRanges) {
                        const [bookedStart, bookedEnd] = range.split(' - ').map(t => parseInt(t.split(':')[0]));
                        // Check if there's any overlap
                        if ((start >= bookedStart && start < bookedEnd) || 
                            (end > bookedStart && end <= bookedEnd) ||
                            (start <= bookedStart && end >= bookedEnd)) {
                            alert('Jam yang dipilih bertabrakan dengan booking yang sudah ada: ' + range);
                            return;
                        }
                    }
                    
                    // Open confirmation modal instead of redirecting directly
                    this.timeModalOpen = false;
                    this.confirmModalOpen = true;
                },

                proceedToBooking() {
                    // Open payment modal instead of redirecting
                    this.confirmModalOpen = false;
                    this.paymentModalOpen = true;
                },

                async processPayment() {
                    if (!this.paymentMethod) {
                        alert('Mohon pilih metode pembayaran');
                        return;
                    }

                    this.paymentLoading = true;

                    try {
                        // Create booking
                        const bookingData = {
                            service_id: this.serviceId,
                            date: this.selectedDate,
                            start_time: this.startTime,
                            end_time: this.endTime,
                            payment_method: this.paymentMethod,
                            total_amount: this.calculateTotal()
                        };

                        const response = await fetch('/api/bookings/create', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(bookingData)
                        });

                        const result = await response.json();

                        if (result.success) {
                            if (result.snap_token) {
                                // Process with Midtrans Snap for all payment methods
                                const self = this;
                                window.snap.pay(result.snap_token, {
                                    onSuccess: function(res) {
                                        // Show success modal instead of redirect
                                        self.paymentModalOpen = false;
                                        self.successInfo = {
                                            order_id: res.order_id || res.transaction_id || result.order_id || result.booking_id,
                                            amount: self.calculateTotal(),
                                            raw: res
                                        };
                                        self.successModalOpen = true;
                                    },
                                    onPending: function(res) {
                                        // Show pending page or modal - keep redirect for now
                                        window.location = '/booking/pending/' + (res.order_id || result.order_id || result.booking_id);
                                    },
                                    onError: function(res) {
                                        alert('Pembayaran gagal. Silakan coba lagi.');
                                        console.error(res);
                                    },
                                    onClose: function() {
                                        console.log('Payment popup closed');
                                    }
                                });
                            } else if (result.use_manual_payment) {
                                // Midtrans not available, show manual payment instructions
                                alert('Booking berhasil dibuat!\n\nSilakan lakukan pembayaran manual.\nBooking ID: ' + result.booking_id);
                                window.location = '/';
                            } else {
                                // Fallback redirect
                                alert('Booking berhasil dibuat! Booking ID: ' + result.booking_id);
                                window.location = '/';
                            }
                        } else {
                            alert(result.message || 'Terjadi kesalahan saat membuat booking');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    } finally {
                        this.paymentLoading = false;
                    }
                },

                calculateDuration() {
                    if (!this.startTime || !this.endTime) return 0;
                    
                    // Parse time strings - handle both HH:MM and H:MM formats
                    const parseTime = (timeStr) => {
                        if (!timeStr) return 0;
                        const parts = timeStr.split(':');
                        return parseInt(parts[0]) || 0;
                    };
                    
                    const start = parseTime(this.startTime);
                    const end = parseTime(this.endTime);
                    const duration = end - start;
                    
                    return duration > 0 ? duration : 0;
                },

                calculateTotal() {
                    const duration = this.calculateDuration();
                    const total = duration * this.pricePerHour;
                    return total;
                },
                
                formatTimeInput(event, type) {
                    let value = event.target.value.replace(/[^0-9]/g, '');
                    
                    if (value.length >= 2) {
                        let hours = value.substring(0, 2);
                        let minutes = value.substring(2, 4);
                        
                        // Validate hours (00-22)
                        hours = Math.min(parseInt(hours) || 0, 22).toString().padStart(2, '0');
                        
                        // Validate minutes (00-59)
                        if (minutes) {
                            minutes = Math.min(parseInt(minutes) || 0, 59).toString().padStart(2, '0');
                            value = hours + ':' + minutes;
                        } else {
                            value = hours;
                        }
                        
                        if (type === 'start') {
                            this.startTime = value;
                        } else {
                            this.endTime = value;
                        }
                    }
                },

                prevMonth() {
                    const d = new Date(this.currentYear, this.currentMonth - 2, 1);
                    this.loadMonth(d.getFullYear(), d.getMonth() + 1);
                },

                nextMonth() {
                    const d = new Date(this.currentYear, this.currentMonth, 1);
                    this.loadMonth(d.getFullYear(), d.getMonth() + 1);
                },
                
                // helper to format date nicely
                formatSelectedDate() {
                    if (!this.selectedDate) return '';
                    // Parse date string as local time to avoid timezone issues
                    const parts = this.selectedDate.split('-');
                    const d = new Date(parts[0], parts[1] - 1, parts[2]);
                    return d.toLocaleDateString('id-ID', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                }
            };
        }
    </script>
@endpush
