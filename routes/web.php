<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// ============================================
// PUBLIC ROUTES (Landing Page - No Login)
// ============================================
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/services', [LandingController::class, 'services'])->name('services');
Route::get('/services/{service}', [LandingController::class, 'serviceDetail'])->name('service.detail');

// Search & Preview Booking (tanpa login)
Route::post('/search-slots', [LandingController::class, 'searchSlots'])->name('search.slots');
Route::post('/service-availability', [LandingController::class, 'availability'])->name('service.availability');
Route::post('/service-day-slots', [LandingController::class, 'daySlots'])->name('service.day.slots');
Route::get('/booking/preview/{slot}', [BookingController::class, 'preview'])->name('booking.preview');

// API for booking creation with payment
Route::post('/api/bookings/create', [BookingController::class, 'createBooking'])->name('api.bookings.create');

// ============================================
// AUTHENTICATION ROUTES
// ============================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ============================================
// USER ROUTES (Authenticated)
// ============================================
Route::middleware(['auth'])->group(function () {
    // User Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');

    // Booking Flow (setelah login)
    Route::post('/booking/confirm/{slot}', [BookingController::class, 'confirm'])->name('booking.confirm');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{booking}/details', [BookingController::class, 'details'])->name('booking.details');
    Route::get('/booking/{booking}/qrcode', [BookingController::class, 'generateQRCode'])->name('booking.qrcode');
    
    // Manage Bookings
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('my.bookings');
    Route::post('/booking/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
});

// ============================================
// ADMIN ROUTES (Admin Only)
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Manage Services
    Route::resource('services', AdminController::class.'@services');
    Route::get('/services', [AdminController::class, 'services'])->name('services.index');
    Route::get('/services/create', [AdminController::class, 'createService'])->name('services.create');
    Route::post('/services', [AdminController::class, 'storeService'])->name('services.store');
    Route::get('/services/{service}/edit', [AdminController::class, 'editService'])->name('services.edit');
    Route::put('/services/{service}', [AdminController::class, 'updateService'])->name('services.update');
    Route::delete('/services/{service}', [AdminController::class, 'deleteService'])->name('services.destroy');
    
    // Manage Time Slots
    Route::get('/slots', [AdminController::class, 'slots'])->name('slots.index');
    Route::get('/slots/create', [AdminController::class, 'createSlot'])->name('slots.create');
    Route::post('/slots', [AdminController::class, 'storeSlot'])->name('slots.store');
    Route::delete('/slots/{slot}', [AdminController::class, 'deleteSlot'])->name('slots.destroy');
    
    // Manage Bookings
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings.index');
    Route::post('/bookings/{booking}/confirm', [AdminController::class, 'confirmBooking'])->name('bookings.confirm');
    Route::post('/bookings/{booking}/reject', [AdminController::class, 'rejectBooking'])->name('bookings.reject');
    
    // Statistics
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
});

