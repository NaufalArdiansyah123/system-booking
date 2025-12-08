@extends('layouts.app')

@section('title', 'Booking Lapangan Futsal')

@section('content')
<!-- Hero Section dengan Gambar Futsal -->
<section class="relative bg-gradient-to-br from-green-600 via-green-700 to-green-900 text-white overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 relative z-10">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-full px-5 py-2.5 mb-6">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                    </svg>
                    <span class="text-sm font-semibold">Arena Futsal Terbaik di Kota</span>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                    Booking Lapangan<br/>
                    <span class="text-yellow-400">Futsal Online</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-green-100 leading-relaxed">
                    Pesan lapangan futsal favoritmu dengan mudah, cepat, dan praktis. Main bareng teman jadi lebih seru!
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#booking" class="inline-flex items-center gap-2 bg-yellow-400 text-gray-900 px-8 py-4 rounded-xl font-bold text-lg hover:bg-yellow-300 transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                        Booking Sekarang
                    </a>
                    <a href="#lapangan" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-white/30 transition-all duration-300 border-2 border-white/50 hover:border-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Lihat Lapangan
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 mt-12">
                    <div class="text-center bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                        <div class="text-3xl font-bold text-yellow-400 mb-1">3</div>
                        <div class="text-sm text-green-100">Lapangan</div>
                    </div>
                    <div class="text-center bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                        <div class="text-3xl font-bold text-yellow-400 mb-1">24/7</div>
                        <div class="text-sm text-green-100">Buka</div>
                    </div>
                    <div class="text-center bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                        <div class="text-3xl font-bold text-yellow-400 mb-1">100+</div>
                        <div class="text-sm text-green-100">Member</div>
                    </div>
                </div>
            </div>
            
            <!-- Ilustrasi Futsal -->
            <div class="hidden md:block">
                <div class="relative">
                    <div class="absolute inset-0 bg-yellow-400 rounded-3xl transform rotate-6 opacity-20 blur-xl"></div>
                    <div class="relative bg-white/10 backdrop-blur-md rounded-3xl p-8 border-4 border-white/30 shadow-2xl">
                        <svg class="w-full h-auto" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Lapangan Futsal -->
                            <rect x="50" y="50" width="300" height="300" rx="10" fill="#10B981" stroke="#fff" stroke-width="4"/>
                            <!-- Garis Tengah -->
                            <line x1="200" y1="50" x2="200" y2="350" stroke="#fff" stroke-width="3"/>
                            <!-- Lingkaran Tengah -->
                            <circle cx="200" cy="200" r="40" stroke="#fff" stroke-width="3" fill="none"/>
                            <circle cx="200" cy="200" r="3" fill="#fff"/>
                            <!-- Gawang Kiri -->
                            <rect x="50" y="150" width="30" height="100" fill="#fff" opacity="0.3"/>
                            <!-- Gawang Kanan -->
                            <rect x="320" y="150" width="30" height="100" fill="#fff" opacity="0.3"/>
                            <!-- Bola -->
                            <circle cx="280" cy="180" r="15" fill="#fff"/>
                            <path d="M280 165 L280 195 M265 180 L295 180" stroke="#10B981" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Wave Separator -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V120Z" fill="#F9FAFB"/>
        </svg>
    </div>
</section>

<!-- Booking Form Section - CTA ke halaman Lapangan -->
<section id="booking" class="bg-gray-50 py-16 -mt-1">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-10 border-t-4 border-green-600">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">Booking Lapangan Futsal</h2>
                <p class="text-gray-600 text-lg">Pilih lapangan dan jadwal yang kamu inginkan</p>
            </div>
            
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-green-50 rounded-full mb-6">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Siap Booking Lapangan?</h3>
                <p class="text-gray-600 mb-8 text-lg max-w-2xl mx-auto">Klik tombol di bawah untuk melihat jadwal tersedia dan pilih lapangan favoritmu</p>
                <a href="{{ route('services') }}" class="inline-flex items-center gap-3 bg-gradient-to-r from-green-600 to-green-700 text-white px-12 py-5 rounded-xl font-bold text-xl hover:from-green-700 hover:to-green-800 transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Lihat Jadwal & Booking Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Fasilitas & Layanan Section -->
<section id="lapangan" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-5 py-2.5 rounded-full text-sm font-bold mb-4">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                </svg>
                FASILITAS LENGKAP
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Layanan & Fasilitas</h2>
            <p class="text-gray-600 text-xl max-w-2xl mx-auto">Nikmati berbagai fasilitas premium untuk pengalaman bermain futsal terbaik</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mb-12">
            <!-- Fasilitas 1 -->
            <div class="bg-gradient-to-br from-green-50 to-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-green-100 hover:border-green-500 transform hover:-translate-y-2 group">
                <div class="bg-gradient-to-br from-green-100 to-green-50 h-16 w-16 rounded-2xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Lantai Berkualitas</h3>
                <p class="text-gray-600 text-center leading-relaxed">Pilihan lantai vinyl premium atau rumput sintetis untuk kenyamanan bermain maksimal</p>
            </div>

            <!-- Fasilitas 2 -->
            <div class="bg-gradient-to-br from-green-50 to-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-green-100 hover:border-green-500 transform hover:-translate-y-2 group">
                <div class="bg-gradient-to-br from-green-100 to-green-50 h-16 w-16 rounded-2xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Pencahayaan LED</h3>
                <p class="text-gray-600 text-center leading-relaxed">Sistem lampu LED terang dan hemat energi untuk visibilitas sempurna saat bermain</p>
            </div>

            <!-- Fasilitas 3 -->
            <div class="bg-gradient-to-br from-green-50 to-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-green-100 hover:border-green-500 transform hover:-translate-y-2 group">
                <div class="bg-gradient-to-br from-green-100 to-green-50 h-16 w-16 rounded-2xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Ruang Ganti AC</h3>
                <p class="text-gray-600 text-center leading-relaxed">Ruang ganti bersih dengan AC, shower air hangat, dan loker aman untuk barang berharga</p>
            </div>

            <!-- Fasilitas 4 -->
            <div class="bg-gradient-to-br from-green-50 to-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-green-100 hover:border-green-500 transform hover:-translate-y-2 group">
                <div class="bg-gradient-to-br from-green-100 to-green-50 h-16 w-16 rounded-2xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Area Parkir Luas</h3>
                <p class="text-gray-600 text-center leading-relaxed">Parkir gratis yang luas dan aman untuk mobil dan motor dengan sistem CCTV 24 jam</p>
            </div>

            <!-- Fasilitas 5 -->
            <div class="bg-gradient-to-br from-green-50 to-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-green-100 hover:border-green-500 transform hover:-translate-y-2 group">
                <div class="bg-gradient-to-br from-green-100 to-green-50 h-16 w-16 rounded-2xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Kantin & Minuman</h3>
                <p class="text-gray-600 text-center leading-relaxed">Kantin dengan berbagai pilihan makanan dan minuman segar untuk energi ekstra</p>
            </div>

            <!-- Fasilitas 6 -->
            <div class="bg-gradient-to-br from-green-50 to-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-green-100 hover:border-green-500 transform hover:-translate-y-2 group">
                <div class="bg-gradient-to-br from-green-100 to-green-50 h-16 w-16 rounded-2xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Sound System</h3>
                <p class="text-gray-600 text-center leading-relaxed">Speaker berkualitas dan layar LED di lapangan VIP untuk pengalaman bermain lebih seru</p>
            </div>
        </div>

        <!-- CTA Button ke halaman Lapangan -->
        <div class="text-center">
            <a href="{{ route('services') }}" class="inline-flex items-center gap-3 bg-gradient-to-r from-green-600 to-green-700 text-white px-12 py-4 rounded-xl font-bold text-xl hover:from-green-700 hover:to-green-800 transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Lihat Semua Lapangan
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-gradient-to-br from-green-50 to-green-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 bg-white text-green-700 px-5 py-2.5 rounded-full text-sm font-bold mb-4 shadow-md">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                KEUNGGULAN
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Kenapa Pilih Kami?</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 text-center transform hover:-translate-y-2 group">
                <div class="bg-gradient-to-br from-green-100 to-green-50 h-20 w-20 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Booking Online</h3>
                <p class="text-gray-600 leading-relaxed">Pesan lapangan kapan saja, di mana saja tanpa perlu datang langsung</p>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 text-center transform hover:-translate-y-2 group">
                <div class="bg-gradient-to-br from-green-100 to-green-50 h-20 w-20 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Fasilitas Lengkap</h3>
                <p class="text-gray-600 leading-relaxed">Lapangan berkualitas dengan ruang ganti, toilet, dan area parkir luas</p>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 text-center transform hover:-translate-y-2 group">
                <div class="bg-gradient-to-br from-green-100 to-green-50 h-20 w-20 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Buka 24/7</h3>
                <p class="text-gray-600 leading-relaxed">Fleksibel main pagi, siang, malam, bahkan dini hari sesuai jadwalmu</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
{{-- <section class="py-20 bg-gradient-to-r from-green-600 to-green-800 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-4xl md:text-5xl font-bold mb-6">Siap Main Futsal?</h2>
        <p class="text-xl md:text-2xl mb-8 text-green-100">
            Booking sekarang dan nikmati pengalaman bermain futsal terbaik!
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="#booking" class="inline-flex items-center gap-2 bg-yellow-400 text-gray-900 px-10 py-4 rounded-xl font-bold text-xl hover:bg-yellow-300 transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Booking Lapangan
            </a>
            @guest
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-10 py-4 rounded-xl font-bold text-xl hover:bg-white/30 transition-all duration-300 border-2 border-white hover:border-white/80">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Daftar Gratis
                </a>
            @endguest
        </div>
    </div>
</section> --}}

@endsection