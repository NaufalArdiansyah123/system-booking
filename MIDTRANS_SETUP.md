# Setup Midtrans Payment Gateway

## Langkah-langkah Setup:

### 1. Daftar Akun Midtrans
- Buka https://dashboard.midtrans.com/register
- Daftar akun baru (gunakan Sandbox untuk testing)

### 2. Dapatkan Credentials
- Login ke dashboard Midtrans
- Pilih environment **Sandbox**
- Pergi ke **Settings** → **Access Keys**
- Copy:
  - **Client Key** (contoh: SB-Mid-client-xxx)
  - **Server Key** (contoh: SB-Mid-server-xxx)

### 3. Konfigurasi di Laravel
Edit file `.env`:
```
MIDTRANS_MERCHANT_ID=G123456789
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxx
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false
```

### 4. Testing Payment
Gunakan kartu test berikut di Sandbox:
- **Card Number**: 4811 1111 1111 1114
- **CVV**: 123
- **Exp Date**: 01/25

### 5. Production Setup
Untuk production:
1. Lengkapi verifikasi bisnis di dashboard Midtrans
2. Ganti ke environment Production
3. Update `.env`:
   ```
   MIDTRANS_CLIENT_KEY=Mid-client-xxxxxxxxxx
   MIDTRANS_SERVER_KEY=Mid-server-xxxxxxxxxx
   MIDTRANS_IS_PRODUCTION=true
   ```

## Flow Pembayaran

1. User pilih tanggal & jam booking
2. Konfirmasi booking di modal preview
3. Pilih metode pembayaran
4. Jika pilih Midtrans → popup Snap muncul
5. User bayar menggunakan berbagai metode:
   - Kartu Kredit/Debit
   - Virtual Account (BCA, Mandiri, BNI, BRI, Permata)
   - E-Wallet (GoPay, ShopeePay, QRIS)
   - Transfer Bank
   - Convenience Store (Alfamart, Indomaret)
6. Setelah bayar → redirect ke halaman success/pending

## Callback URL
Untuk notifikasi status pembayaran, tambahkan di Midtrans dashboard:
- **Payment Notification URL**: `https://yourdomain.com/api/midtrans/callback`
- **Finish Redirect URL**: `https://yourdomain.com/booking/success`
- **Unfinish Redirect URL**: `https://yourdomain.com/booking/pending`
- **Error Redirect URL**: `https://yourdomain.com/booking/failed`
