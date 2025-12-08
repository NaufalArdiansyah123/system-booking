# 🎫 Booking System - Versi Sederhana KAI Access

> **Aplikasi sistem booking online yang modern dan mudah digunakan**  
> Dibuat dengan Laravel 11 + Tailwind CSS

![Laravel](https://img.shields.io/badge/Laravel-11-red)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.0-blue)
![PHP](https://img.shields.io/badge/PHP-8.2-purple)

---

## 📋 Fitur Utama

### 🏠 **Landing Page (Tanpa Login)**
- Hero section dengan CTA menarik
- Form pencarian booking (pilih layanan + tanggal)
- Tampilan slot waktu tersedia real-time
- Card list layanan dengan detail harga
- Keunggulan layanan

### 🎯 **Alur Booking (Seperti KAI Access)**
1. User pilih layanan dan tanggal
2. Lihat slot tersedia
3. Preview booking (tanpa login)
4. Redirect ke login (jika belum login)
5. Konfirmasi booking + pilih pembayaran
6. Booking details dengan QR Code

### 👤 **User Dashboard**
- Booking aktif dan riwayat
- Notifikasi status
- Kelola profil
- Cancel booking

### 🔧 **Admin Panel**
- Dashboard statistik
- CRUD Layanan
- Kelola slot waktu
- Konfirmasi/tolak booking
- Statistik lengkap

---

## 🗄️ Database Schema

**5 Tabel Utama:**
- `users` (id, name, email, password, role)
- `services` (id, name, description, price, duration, location, image)
- `time_slots` (id, service_id, date, start_time, end_time, capacity, booked)
- `bookings` (id, user_id, service_id, slot_id, booking_code, status, payment_status)
- `payments` (id, booking_id, amount, method, status, paid_at)

**Lihat ERD lengkap:** [DOCUMENTATION.md](DOCUMENTATION.md)

---

## 🚀 Instalasi

### 1. Clone & Setup
```bash
git clone <repository-url> system-booking
cd system-booking
composer install
npm install
```

### 2. Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
DB_DATABASE=booking_system
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Setup Database
```bash
# Buat database
mysql -u root -e "CREATE DATABASE booking_system"

# Jalankan migration + seeder
php artisan migrate:fresh --seed
```

### 4. Compile Assets
```bash
npm run dev
# atau untuk production:
npm run build
```

### 5. Jalankan Server
```bash
php artisan serve
# Buka: http://localhost:8000
```

---

## 🔑 Login Credentials

### Admin
```
Email    : admin@booking.com
Password : password
```

### User Demo
```
Email    : user@booking.com
Password : password
```

---

## 📂 Struktur Proyek

```
system-booking/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/ (Login, Register)
│   │   │   ├── AdminController.php
│   │   │   ├── BookingController.php
│   │   │   ├── DashboardController.php
│   │   │   └── LandingController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/ (User, Service, TimeSlot, Booking, Payment)
│
├── database/
│   ├── migrations/ (5 tabel)
│   └── seeders/ (Admin, Services, TimeSlots)
│
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── landing/ (index, services, service-detail)
│   ├── auth/ (login, register)
│   ├── booking/ (preview, confirm, details, my-bookings)
│   ├── dashboard/ (index, profile)
│   └── admin/ (dashboard, services, slots, bookings)
│
└── routes/web.php
```

---

## 🎨 Tech Stack

- **Backend:** Laravel 11
- **Frontend:** Tailwind CSS + Alpine.js
- **Database:** MySQL
- **Asset Bundling:** Vite

---

## 📚 Dokumentasi Lengkap

Untuk dokumentasi detail termasuk:
- ERD Database
- Wireframe UI/UX
- API Endpoints
- Alur booking lengkap
- Enhancement ideas

**Baca:** [DOCUMENTATION.md](DOCUMENTATION.md)

---

## 🧪 Testing

### Manual Testing Checklist
```bash
✓ Landing page & search booking
✓ Auth (login/register/logout)
✓ Booking flow (preview → confirm → details)
✓ User dashboard & profile
✓ Admin panel (CRUD services, slots, bookings)
✓ QR Code generation
✓ Cancel booking
```

---

## 🛠️ Development

### Run Development Server
```bash
php artisan serve
npm run dev
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Generate New Migration
```bash
php artisan make:migration create_table_name
php artisan migrate
```

---

## 📝 TODO / Enhancement

- [ ] Email notifications
- [ ] Payment gateway (Midtrans)

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
