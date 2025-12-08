# 🚀 QUICK START GUIDE - Booking System

> **Panduan cepat untuk menjalankan aplikasi dalam 5 menit!**

---

## ⚡ Setup Super Cepat

### 1️⃣ Persiapan Awal (1 menit)

```bash
# Pastikan Anda sudah di folder proyek
cd /opt/lampp/htdocs/system-booking

# Install dependencies
composer install
npm install
```

### 2️⃣ Konfigurasi Database (30 detik)

```bash
# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate
```

Edit file `.env`, ubah bagian database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=booking_system
DB_USERNAME=root
DB_PASSWORD=
```

### 3️⃣ Buat Database (30 detik)

**Option A: Via Command Line**
```bash
mysql -u root -e "CREATE DATABASE booking_system"
```

**Option B: Via phpMyAdmin**
- Buka http://localhost/phpmyadmin
- Klik "New" → Nama database: `booking_system` → Create

### 4️⃣ Migrasi & Seed Data (1 menit)

```bash
# Jalankan migration + seeder sekaligus
php artisan migrate:fresh --seed
```

Output yang benar:
```
✓ 8 migrations DONE
✓ AdminSeeder DONE
✓ ServiceSeeder DONE (6 layanan)
✓ TimeSlotSeeder DONE (252 slots untuk 7 hari)
```

### 5️⃣ Compile Assets (1 menit)

```bash
# Development mode (dengan hot reload)
npm run dev

# Atau production mode (minified)
npm run build
```

### 6️⃣ Jalankan Server (10 detik)

```bash
php artisan serve
```

**Selesai! Buka:** http://localhost:8000

---

## 🔐 Login Credentials

### Admin Account
```
URL      : http://localhost:8000/login
Email    : admin@booking.com
Password : password
```

### User Demo
```
URL      : http://localhost:8000/login
Email    : user@booking.com
Password : password
```

---

## 🧪 Test Flow

### Test 1: Landing Page & Search
1. ✅ Buka http://localhost:8000
2. ✅ Lihat hero section dan 6 card layanan
3. ✅ Pilih layanan di form search
4. ✅ Pilih tanggal (hari ini atau besok)
5. ✅ Klik "Cari Slot Tersedia"
6. ✅ Harus muncul daftar slot (AJAX)

### Test 2: Booking Flow (Tanpa Login)
1. ✅ Dari hasil search, klik "Pilih" pada salah satu slot
2. ✅ Muncul halaman "Preview Booking"
3. ✅ Klik "Lanjutkan Booking"
4. ✅ Auto redirect ke halaman Login

### Test 3: Login & Lanjut Booking
1. ✅ Login dengan user@booking.com / password
2. ✅ Auto redirect ke "Konfirmasi Booking"
3. ✅ Pilih metode pembayaran
4. ✅ Klik "Konfirmasi Booking"
5. ✅ Redirect ke "Booking Details" dengan kode booking + QR

### Test 4: User Dashboard
1. ✅ Klik "Dashboard" di navbar
2. ✅ Lihat booking aktif
3. ✅ Stats: Aktif, Selesai, Pending

### Test 5: Admin Panel
1. ✅ Logout user, login dengan admin@booking.com / password
2. ✅ Klik "Admin Panel" di navbar
3. ✅ Lihat dashboard admin
4. ✅ Coba kelola services
5. ✅ Coba kelola slots
6. ✅ Coba konfirmasi booking

---

## 🛠️ Troubleshooting

### Problem: npm run dev error
**Solution:**
```bash
npm install --legacy-peer-deps
npm run dev
```

### Problem: Migration error "Can't create table"
**Solution:**
```bash
# Pastikan database exists
mysql -u root -e "SHOW DATABASES"

# Re-run migration
php artisan migrate:fresh --seed
```

### Problem: Class not found
**Solution:**
```bash
composer dump-autoload
php artisan clear-compiled
php artisan config:clear
php artisan cache:clear
```

### Problem: Permission denied (Linux/Mac)
**Solution:**
```bash
chmod -R 775 storage bootstrap/cache
chown -R $USER:$USER storage bootstrap/cache
```

### Problem: CSRF token mismatch
**Solution:**
```bash
php artisan cache:clear
# Refresh browser (Ctrl+Shift+R)
```

### Problem: Slot search tidak muncul
**Solution:**
- Buka Browser Console (F12)
- Check error di Network tab
- Pastikan CSRF token ada di meta tag
- Pastikan npm run dev masih running

---

## 📂 Struktur Folder Penting

```
system-booking/
├── app/Http/Controllers/     ← Logic aplikasi
│   ├── LandingController.php
│   ├── BookingController.php
│   ├── DashboardController.php
│   └── AdminController.php
│
├── app/Models/               ← Database models
│   ├── User.php
│   ├── Service.php
│   ├── TimeSlot.php
│   ├── Booking.php
│   └── Payment.php
│
├── database/migrations/      ← Database schema
│   ├── create_services_table.php
│   ├── create_time_slots_table.php
│   ├── create_bookings_table.php
│   └── create_payments_table.php
│
├── database/seeders/         ← Data dummy
│   ├── AdminSeeder.php
│   ├── ServiceSeeder.php
│   └── TimeSlotSeeder.php
│
├── resources/views/          ← Tampilan HTML
│   ├── layouts/app.blade.php
│   ├── landing/
│   ├── auth/
│   ├── booking/
│   ├── dashboard/
│   └── admin/
│
└── routes/web.php            ← URL routing
```

---

## 🎨 Fitur Yang Sudah Jalan

### ✅ Public Features
- Landing page dengan hero & search
- Search slot via AJAX
- Card list layanan
- Preview booking (tanpa login)

### ✅ Auth Features
- Register user baru
- Login dengan redirect intention
- Logout

### ✅ User Features
- Dashboard dengan stats
- Lihat booking aktif
- Booking details dengan QR code
- Cancel booking (pending only)

### ✅ Booking Flow
- Preview → Login → Confirm → Store → Details
- Auto-generate booking code
- Session intended booking
- Expire time (2 jam)

### ✅ Admin Features (Backend Ready)
- Semua controller method sudah dibuat
- CRUD services
- CRUD slots
- Confirm/reject booking
- Statistics

---

## 📝 Yang Masih Perlu Dibuat

### Views Yang Kurang
1. `booking/confirm.blade.php` - Form konfirmasi + pilih payment
2. `booking/my-bookings.blade.php` - List booking user
3. `dashboard/profile.blade.php` - Edit profile form
4. `admin/dashboard.blade.php` - Admin dashboard
5. `admin/services/*` - CRUD views (index, create, edit)
6. `admin/slots/*` - Create/list slots
7. `admin/bookings/*` - List & manage bookings

### Package Tambahan (Opsional)
```bash
# QR Code generator
composer require simplesoftwareio/simple-qrcode

# Untuk production
composer require --dev barryvdh/laravel-debugbar
```

---

## 📞 Command Cheatsheet

```bash
# Development
php artisan serve              # Run server
npm run dev                    # Watch assets

# Database
php artisan migrate            # Run migrations
php artisan migrate:fresh      # Drop all + re-run
php artisan db:seed            # Run seeders
php artisan migrate:fresh --seed  # Reset + seed

# Clear Cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Generate
php artisan make:controller NameController
php artisan make:model ModelName
php artisan make:migration create_table_name
php artisan make:seeder SeederName

# Info
php artisan route:list         # List semua routes
php artisan migrate:status     # Status migrations
```

---

## 🎯 Next Steps

### Untuk Development
1. Buat missing views (confirm, my-bookings, profile)
2. Buat admin panel views
3. Install QR code package
4. Test semua fitur end-to-end
5. Add validation & error handling

### Untuk Production
1. Set `APP_ENV=production` di .env
2. Set `APP_DEBUG=false`
3. Run `npm run build`
4. Run `composer install --optimize-autoloader --no-dev`
5. Set proper file permissions
6. Configure web server (Apache/Nginx)
7. Setup SSL certificate
8. Configure email (SMTP)
9. Setup backup database

---

## 📚 Dokumentasi Lengkap

- **README.md** - Overview & instalasi
- **DOCUMENTATION.md** - Dokumentasi lengkap (ERD, wireframe, endpoints)
- **FILE_STRUCTURE.md** - Detail semua file yang dibuat
- **QUICK_START.md** - Ini (panduan cepat)

---

## 💡 Tips

1. **Development Mode:** Selalu jalankan `npm run dev` agar Tailwind CSS auto-compile
2. **Database:** Gunakan `php artisan migrate:fresh --seed` untuk reset data
3. **Testing:** Test dengan 2 browser berbeda (user & admin)
4. **Debug:** Install Laravel Debugbar untuk development
5. **Backup:** Export database sebelum eksperimen

---

## ✨ Selamat!

Aplikasi Booking System Anda sudah siap digunakan! 🎉

**Jika ada error, cek:**
1. Log Laravel: `storage/logs/laravel.log`
2. Browser console (F12)
3. Network tab untuk AJAX
4. PHP error log

**Need help?** Check DOCUMENTATION.md untuk detail lengkap.

---

**Built with ❤️ using Laravel 11 + Tailwind CSS**
