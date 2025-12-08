# 📚 BOOKING SYSTEM - DOKUMENTASI LENGKAP

> **Aplikasi Booking System seperti KAI Access versi sederhana**  
> Dibuat dengan **Laravel 11 + Tailwind CSS**

---

## 📋 DAFTAR ISI

1. [Konsep & Fitur](#konsep--fitur)
2. [ERD Database](#erd-database)
3. [Struktur Proyek](#struktur-proyek)
4. [Instalasi](#instalasi)
5. [Alur Booking](#alur-booking)
6. [Wireframe & UI Design](#wireframe--ui-design)
7. [API Endpoints](#api-endpoints)
8. [Login Credentials](#login-credentials)

---

## 🎯 KONSEP & FITUR

### **Landing Page (Tanpa Login)**
User dapat:
- ✅ Melihat hero section dengan CTA
- ✅ Mencari jadwal dengan form pencarian (pilih layanan + tanggal)
- ✅ Melihat card list layanan
- ✅ Melihat slot waktu tersedia
- ✅ Melihat harga dan detail layanan
- ❌ **TIDAK BISA** booking sebelum login

### **Alur Booking (Seperti KAI Access)**
1. User pilih layanan di landing
2. User pilih tanggal
3. Sistem tampilkan slot waktu tersedia
4. User klik slot → **Preview Booking** (layanan, tanggal, jam, harga, lokasi)
5. Klik "Lanjutkan Booking" → **Redirect ke Login** (jika belum login)
6. Setelah login → **Konfirmasi Booking** (pilih metode pembayaran)
7. Klik "Konfirmasi" → **Booking Details** (kode booking, status, QR code)

### **User Dashboard (Setelah Login)**
- ✅ Lihat booking aktif
- ✅ Riwayat booking
- ✅ Notifikasi status
- ✅ Tombol "Buat Booking Baru"
- ✅ Profil user (edit nama, email, password)

### **Admin Panel**
Admin dapat:
- ✅ Dashboard statistik (total booking, revenue, dll)
- ✅ Kelola layanan (CRUD services)
- ✅ Kelola slot waktu (create, delete slots)
- ✅ Kelola booking (konfirmasi/tolak booking)
- ✅ Lihat statistik lengkap

---

## 🗄️ ERD DATABASE

```
┌─────────────────┐
│     users       │
├─────────────────┤
│ id              │
│ name            │
│ email           │
│ password        │
│ role (enum)     │◄──┐
│ created_at      │   │
│ updated_at      │   │
└─────────────────┘   │
                      │
┌─────────────────┐   │
│   services      │   │
├─────────────────┤   │
│ id              │◄──┼──┐
│ name            │   │  │
│ description     │   │  │
│ price           │   │  │
│ duration        │   │  │
│ location        │   │  │
│ image           │   │  │
│ is_active       │   │  │
│ created_at      │   │  │
│ updated_at      │   │  │
└─────────────────┘   │  │
                      │  │
┌─────────────────┐   │  │
│   time_slots    │   │  │
├─────────────────┤   │  │
│ id              │◄──┼──┼──┐
│ service_id (FK) │───┘  │  │
│ date            │      │  │
│ start_time      │      │  │
│ end_time        │      │  │
│ capacity        │      │  │
│ booked          │      │  │
│ is_available    │      │  │
│ created_at      │      │  │
│ updated_at      │      │  │
└─────────────────┘      │  │
                         │  │
┌─────────────────┐      │  │
│    bookings     │      │  │
├─────────────────┤      │  │
│ id              │◄─────┼──┼──┐
│ user_id (FK)    │──────┘  │  │
│ service_id (FK) │─────────┘  │
│ slot_id (FK)    │────────────┘
│ booking_code    │
│ status (enum)   │
│ payment_status  │
│ note            │
│ expires_at      │
│ created_at      │
│ updated_at      │
└─────────────────┘
        │
        │
┌─────────────────┐
│    payments     │
├─────────────────┤
│ id              │
│ booking_id (FK) │──┘
│ amount          │
│ method (enum)   │
│ status (enum)   │
│ transaction_id  │
│ paid_at         │
│ created_at      │
│ updated_at      │
└─────────────────┘
```

### **Relasi:**
- `users` (1) → (N) `bookings`
- `services` (1) → (N) `time_slots`
- `services` (1) → (N) `bookings`
- `time_slots` (1) → (N) `bookings`
- `bookings` (1) → (1) `payments`

---

## 📁 STRUKTUR PROYEK

```
system-booking/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   └── RegisterController.php
│   │   │   ├── AdminController.php
│   │   │   ├── BookingController.php
│   │   │   ├── DashboardController.php
│   │   │   └── LandingController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── Booking.php (+ auto generate booking_code)
│       ├── Payment.php
│       ├── Service.php
│       ├── TimeSlot.php
│       └── User.php (+ isAdmin() method)
│
├── database/
│   ├── migrations/
│   │   ├── 2025_12_08_add_role_to_users_table.php
│   │   ├── 2025_12_08_create_services_table.php
│   │   ├── 2025_12_08_create_time_slots_table.php
│   │   ├── 2025_12_08_create_bookings_table.php
│   │   └── 2025_12_08_create_payments_table.php
│   └── seeders/
│       ├── AdminSeeder.php (admin + user demo)
│       ├── ServiceSeeder.php (6 layanan)
│       └── TimeSlotSeeder.php (7 hari ke depan)
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php (navbar, footer, flash messages)
│       ├── landing/
│       │   ├── index.blade.php (hero + search + services)
│       │   ├── services.blade.php (all services)
│       │   └── service-detail.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── booking/
│       │   ├── preview.blade.php (preview booking tanpa login)
│       │   ├── confirm.blade.php (konfirmasi + pilih payment)
│       │   ├── details.blade.php (booking details + QR)
│       │   └── my-bookings.blade.php
│       ├── dashboard/
│       │   ├── index.blade.php (user dashboard)
│       │   └── profile.blade.php
│       └── admin/
│           ├── dashboard.blade.php
│           ├── services/ (index, create, edit)
│           ├── slots/ (index, create)
│           ├── bookings/ (index)
│           └── statistics.blade.php
│
└── routes/
    └── web.php (public, auth, user, admin routes)
```

---

## 🚀 INSTALASI

### **1. Clone & Setup**
```bash
cd /opt/lampp/htdocs/system-booking

# Install dependencies
composer install
npm install

# Copy environment
cp .env.example .env
php artisan key:generate

# Konfigurasi database di .env
DB_DATABASE=booking_system
DB_USERNAME=root
DB_PASSWORD=
```

### **2. Migrasi & Seed Database**
```bash
# Jalankan migration
php artisan migrate

# Seed data dummy
php artisan db:seed

# Atau sekaligus:
php artisan migrate:fresh --seed
```

### **3. Link Storage (untuk upload gambar)**
```bash
php artisan storage:link
```

### **4. Compile Assets (Tailwind CSS)**
```bash
npm run dev
# atau untuk production:
npm run build
```

### **5. Jalankan Server**
```bash
php artisan serve
# Buka: http://localhost:8000
```

---

## 🔄 ALUR BOOKING LENGKAP

### **Scenario 1: User Belum Login**
```
1. Buka Landing Page (/)
   → Hero Section
   → Form Search: Pilih Layanan + Tanggal
   → Klik "Cari Slot Tersedia"

2. Sistem tampilkan slot tersedia (AJAX)
   → User klik "Pilih" pada slot

3. Redirect ke Preview Booking (/booking/preview/{slot})
   → Tampilkan detail: Layanan, Tanggal, Jam, Harga, Lokasi
   → Tombol "Lanjutkan Booking"

4. Klik "Lanjutkan Booking"
   → Redirect ke Login (/login)
   → Sistem simpan intended slot di session

5. Setelah Login/Register
   → Auto redirect ke Konfirmasi Booking (/booking/confirm/{slot})
```

### **Scenario 2: Konfirmasi Booking (Setelah Login)**
```
1. Halaman Konfirmasi Booking
   → Detail pesanan
   → Pilih metode pembayaran (transfer/e-wallet/credit card/cash)
   → Tombol "Konfirmasi Booking"

2. Klik "Konfirmasi Booking"
   → Sistem buat record Booking (status: pending)
   → Sistem buat record Payment (status: pending)
   → Sistem update slot (booked++)
   → Generate booking_code otomatis (BK-XXXXXX)

3. Redirect ke Booking Details (/booking/{id}/details)
   → Tampilkan:
     - Kode Booking
     - Status (Pending)
     - QR Code
     - Detail lengkap
   → User bisa download QR atau print
```

### **Scenario 3: Admin Konfirmasi**
```
1. Admin login ke /admin/dashboard
2. Lihat list booking di /admin/bookings
3. Klik "Konfirmasi" pada booking pending
   → Status booking → confirmed
   → Payment status → paid
   → User dapat notifikasi (via flash message saat login)
```

---

## 🎨 WIREFRAME & UI DESIGN

### **1. Landing Page**
```
┌─────────────────────────────────────────────────┐
│  [LOGO] Beranda  Layanan  [Masuk] [Daftar]     │
├─────────────────────────────────────────────────┤
│                                                 │
│           BOOKING LAYANAN JADI LEBIH MUDAH      │
│        Pilih layanan, pilih waktu, selesai!     │
│                                                 │
│        [Mulai Booking]  [Lihat Layanan]         │
│                                                 │
├─────────────────────────────────────────────────┤
│  ┌───────────────────────────────────────────┐  │
│  │      📝 CARI JADWAL BOOKING               │  │
│  │  [Pilih Layanan ▼] [Pilih Tanggal]       │  │
│  │       [🔍 Cari Slot Tersedia]             │  │
│  └───────────────────────────────────────────┘  │
├─────────────────────────────────────────────────┤
│  LAYANAN KAMI                                   │
│  ┌────────┐ ┌────────┐ ┌────────┐              │
│  │ [IMG]  │ │ [IMG]  │ │ [IMG]  │              │
│  │Konsul  │ │ Yoga   │ │ Dokter │              │
│  │250k    │ │ 100k   │ │ 150k   │              │
│  │[Detail]│ │[Detail]│ │[Detail]│              │
│  └────────┘ └────────┘ └────────┘              │
└─────────────────────────────────────────────────┘
```

### **2. Preview Booking (Tanpa Login)**
```
┌─────────────────────────────────────────────────┐
│             PREVIEW BOOKING                     │
├─────────────────────────────────────────────────┤
│  Layanan     : Konsultasi Bisnis                │
│  Tanggal     : 10 Desember 2025                 │
│  Jam         : 09:00 - 10:00                    │
│  Durasi      : 60 menit                         │
│  Harga       : Rp 250.000                       │
│  Lokasi      : Jakarta                          │
│  Catatan     : [textarea]                       │
│                                                 │
│         [🔒 Lanjutkan Booking]                  │
│     (Anda harus login terlebih dahulu)          │
└─────────────────────────────────────────────────┘
```

### **3. Konfirmasi Booking (Setelah Login)**
```
┌─────────────────────────────────────────────────┐
│         KONFIRMASI BOOKING                      │
├─────────────────────────────────────────────────┤
│  Detail Pesanan:                                │
│  ✓ Konsultasi Bisnis                            │
│  ✓ 10 Des 2025, 09:00 - 10:00                   │
│  ✓ Rp 250.000                                   │
│                                                 │
│  Metode Pembayaran:                             │
│  ( ) Transfer Bank                              │
│  ( ) E-Wallet                                   │
│  ( ) Credit Card                                │
│  (•) Cash                                       │
│                                                 │
│         [✓ Konfirmasi Booking]                  │
└─────────────────────────────────────────────────┘
```

### **4. Booking Details**
```
┌─────────────────────────────────────────────────┐
│         BOOKING BERHASIL! 🎉                    │
├─────────────────────────────────────────────────┤
│  Kode Booking: BK-A3F7G2K1                      │
│  Status      : ⏳ Pending                       │
│                                                 │
│       ┌───────────────┐                         │
│       │   QR CODE     │                         │
│       │   [████████]  │                         │
│       │               │                         │
│       └───────────────┘                         │
│                                                 │
│  📅 10 Desember 2025                            │
│  🕐 09:00 - 10:00                               │
│  💰 Rp 250.000                                  │
│  📍 Jakarta                                     │
│                                                 │
│  [Download QR]  [Print]  [Dashboard]            │
└─────────────────────────────────────────────────┘
```

### **5. User Dashboard**
```
┌─────────────────────────────────────────────────┐
│  Dashboard   Booking Saya   Profil   [Logout]  │
├─────────────────────────────────────────────────┤
│  Selamat datang, User Demo! 👋                  │
│                                                 │
│  ┌──────────┐ ┌──────────┐ ┌──────────┐        │
│  │  AKTIF   │ │ SELESAI  │ │ PENDING  │        │
│  │    3     │ │    12    │ │    1     │        │
│  └──────────┘ └──────────┘ └──────────┘        │
│                                                 │
│  Booking Aktif:                                 │
│  ┌─────────────────────────────────────────┐   │
│  │ BK-XXX | Konsultasi | 10 Des | Pending  │   │
│  │        [Detail] [Cancel]                 │   │
│  └─────────────────────────────────────────┘   │
│                                                 │
│         [➕ Buat Booking Baru]                  │
└─────────────────────────────────────────────────┘
```

### **6. Admin Dashboard**
```
┌─────────────────────────────────────────────────┐
│ Admin Panel | Services | Slots | Bookings       │
├─────────────────────────────────────────────────┤
│  STATISTIK                                      │
│  ┌─────────┐ ┌─────────┐ ┌─────────┐           │
│  │ BOOKING │ │ REVENUE │ │ PENDING │           │
│  │   125   │ │ 15.5M   │ │    8    │           │
│  └─────────┘ └─────────┘ └─────────┘           │
│                                                 │
│  Booking Terbaru:                               │
│  [Table dengan action Konfirmasi/Tolak]         │
└─────────────────────────────────────────────────┘
```

---

## 🔗 API ENDPOINTS

### **Public Routes (No Auth)**
```
GET  /                          → Landing page
GET  /services                  → All services
GET  /services/{id}             → Service detail
POST /search-slots              → Search available slots (AJAX)
GET  /booking/preview/{slot}    → Preview booking (no login)
```

### **Auth Routes**
```
GET  /login                     → Login form
POST /login                     → Process login
GET  /register                  → Register form
POST /register                  → Process register
POST /logout                    → Logout
```

### **User Routes (Auth Required)**
```
GET  /dashboard                 → User dashboard
GET  /profile                   → User profile
PUT  /profile                   → Update profile

POST /booking/confirm/{slot}    → Confirm booking page
POST /booking/store             → Store booking
GET  /booking/{id}/details      → Booking details
GET  /booking/{id}/qrcode       → Generate QR code
GET  /my-bookings               → My bookings list
POST /booking/{id}/cancel       → Cancel booking
```

### **Admin Routes (Admin Only)**
```
GET  /admin/dashboard           → Admin dashboard
GET  /admin/services            → List services
POST /admin/services            → Create service
PUT  /admin/services/{id}       → Update service
DELETE /admin/services/{id}     → Delete service

GET  /admin/slots               → List time slots
POST /admin/slots               → Create slot
DELETE /admin/slots/{id}        → Delete slot

GET  /admin/bookings            → List all bookings
POST /admin/bookings/{id}/confirm → Confirm booking
POST /admin/bookings/{id}/reject  → Reject booking

GET  /admin/statistics          → Statistics page
```

---

## 🔑 LOGIN CREDENTIALS

Setelah menjalankan seeder, gunakan credentials berikut:

### **Admin Account**
```
Email    : admin@booking.com
Password : password
Role     : admin
```

### **User Demo Account**
```
Email    : user@booking.com
Password : password
Role     : user
```

---

## ⚙️ FITUR TAMBAHAN OPSIONAL

### **1. QR Code untuk Booking**
Package yang digunakan: `simplesoftwareio/simple-qrcode`

Install:
```bash
composer require simplesoftwareio/simple-qrcode
```

Sudah terintegrasi di `BookingController@generateQRCode()`

### **2. Auto Expire Booking**
Booking akan expire otomatis dalam 2 jam jika tidak dikonfirmasi.

Buat command untuk check expired bookings:
```bash
php artisan make:command CheckExpiredBookings
```

Schedule di `app/Console/Kernel.php`:
```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('bookings:check-expired')->everyFiveMinutes();
}
```

### **3. Email Notification**
Tambahkan email notification untuk:
- Booking berhasil dibuat
- Booking dikonfirmasi admin
- Booking dibatalkan
- Reminder H-1

### **4. Dark Mode**
Tambahkan toggle dark mode dengan Alpine.js dan Tailwind dark classes.

### **5. Kalender Interaktif**
Gunakan library seperti FullCalendar atau flatpickr untuk memilih tanggal lebih interaktif.

---

## 🎨 GAYA UI/UX

### **Color Palette**
```
Primary    : #2563EB (Blue 600)
Secondary  : #1E40AF (Blue 800)
Success    : #10B981 (Green 500)
Warning    : #F59E0B (Amber 500)
Danger     : #EF4444 (Red 500)
Gray       : #6B7280 (Gray 500)
Background : #F9FAFB (Gray 50)
```

### **Typography**
- Font: System Font Stack (font-sans)
- Heading: Bold (font-bold)
- Body: Regular (font-normal)

### **Components**
- Cards: rounded-xl shadow-md
- Buttons: rounded-lg px-6 py-3
- Inputs: rounded-lg border border-gray-300
- Hover: transition duration-300

---

## 🧪 TESTING

### **Manual Testing Checklist**

**Landing Page:**
- [ ] Hero section tampil dengan benar
- [ ] Form search berfungsi (pilih layanan + tanggal)
- [ ] Hasil slot tampil via AJAX
- [ ] Card layanan tampil dengan benar

**Auth:**
- [ ] Register user baru berhasil
- [ ] Login dengan email/password benar
- [ ] Logout berhasil redirect ke home

**Booking Flow:**
- [ ] Preview booking tanpa login berfungsi
- [ ] Redirect ke login jika belum login
- [ ] Setelah login auto redirect ke konfirmasi
- [ ] Konfirmasi booking berhasil create record
- [ ] Booking details tampil dengan benar
- [ ] QR Code generate dengan benar

**User Dashboard:**
- [ ] Tampil booking aktif
- [ ] Tampil riwayat booking
- [ ] Cancel booking berhasil
- [ ] Update profile berhasil

**Admin Panel:**
- [ ] Dashboard statistik tampil benar
- [ ] CRUD services berfungsi
- [ ] Create/delete slots berfungsi
- [ ] Konfirmasi/tolak booking berfungsi

---

## 📝 CATATAN PENGEMBANGAN

### **Database Indexes**
Sudah ditambahkan index pada:
- `time_slots`: (service_id, date, is_available)
- `bookings`: (user_id, status), (booking_code)
- `payments`: (booking_id)

### **Security**
- CSRF protection aktif
- Password di-hash dengan bcrypt
- Admin middleware mencegah akses unauthorized
- Input validation di setiap form

### **Performance**
- Eager loading untuk relasi (`with()`)
- Pagination untuk list data
- AJAX untuk search tanpa reload page

---

## 🚧 TODO / ENHANCEMENT

- [ ] Notifikasi real-time (Pusher/Laravel Echo)
- [ ] Export booking ke PDF
- [ ] Multi-language support
- [ ] Payment gateway integration (Midtrans, dll)
- [ ] Rating & review system
- [ ] Email verification
- [ ] Password reset
- [ ] Booking reminder via WhatsApp
- [ ] Mobile responsive optimization
- [ ] PWA (Progressive Web App)

---

## 📞 SUPPORT

Jika ada pertanyaan atau issue:
1. Check dokumentasi ini terlebih dahulu
2. Review kode di folder yang relevan
3. Test dengan data seeder yang sudah disediakan

---

**Built with ❤️ using Laravel 11 + Tailwind CSS**

**© 2025 BookingApp - All Rights Reserved**
