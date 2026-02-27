# Indonesia Luxe

Aplikasi web booking paket wisata berbasis Laravel 11 dan Livewire 3. Dibangun untuk kebutuhan internal dengan alur pemesanan end-to-end: dari pencarian paket, checkout, upload bukti bayar, sampai verifikasi oleh admin.

---

## Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL

---

## Installation

```bash
# Install dependencies
composer install
npm install && npm run build

# Setup environment
cp .env.example .env
php artisan key:generate

# Konfigurasi database di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=indonesia_luxe
DB_USERNAME=root
DB_PASSWORD=

# Jalankan migasi dan seeder
php artisan migrate --seed
php artisan storage:link

# Jalankan server development
php artisan serve
```

Aplikasi berjalan di `http://localhost:8000`.

---

## Default Credentials

| Role   | Email                      | Password |
|--------|----------------------------|----------|
| Admin  | admin@indonesialuxe.com    | password |
| Vendor | vendor@indonesialuxe.com   | password |
| User   | user@indonesialuxe.com     | password |

---

## Fitur Utama

**Sisi User**
- Homepage dengan hero video background
- Pencarian dan filter paket secara real-time (Livewire)
- Halaman detail paket dengan galeri foto dan itinerary
- Keranjang belanja — bisa pilih beberapa paket sekaligus
- Checkout dengan upload bukti transfer manual
- Halaman tracking status booking

**Dashboard Vendor**
- Manajemen paket wisata (tambah, edit, hapus)
- Monitoring booking yang masuk
- Laporan transaksi per periode

**Dashboard Admin**
- Persetujuan akun vendor baru
- Validasi pembayaran user
- Monitoring seluruh transaksi
- Laporan bulanan

---

## Struktur Direktori

```
app/
├── Http/
│   ├── Controllers/        # PackageController, BookingController, PageController
│   └── Middleware/         # AdminMiddleware, VendorMiddleware
├── Livewire/
│   ├── Admin/              # AdminDashboard, PaymentValidation
│   ├── Vendor/             # VendorDashboard, PackageManager
│   └── SearchPackages.php, CartComponent.php, CheckoutComponent.php
└── Models/                 # User, Package, Booking, Payment, Review, Vendor

resources/views/
├── layouts/                # app.blade.php — layout utama dengan navbar dan footer
├── sections/               # hero, categories, featured-packages, testimonials
├── pages/                  # home, search, package-detail, checkout, booking-status
└── livewire/               # blade views untuk setiap Livewire component

database/
├── migrations/             # 8 tabel: users, vendors, packages, bookings, payments, dst.
└── seeders/                # DatabaseSeeder — data dummy siap pakai

routes/
└── web.php                 # Semua route, termasuk grup auth dan role middleware
```

---

## Tech Stack

| Komponen   | Teknologi                      |
|------------|-------------------------------|
| Backend    | Laravel 11, PHP 8.2           |
| Reaktivitas| Livewire 3, Alpine.js         |
| Styling    | Tailwind CSS (via CDN)        |
| Database   | MySQL                         |
| Auth       | Laravel Fortify               |
| Dev Tools  | Laravel Pint, Ignition, Sail  |

---

## Perintah yang Sering Dipakai

```bash
# Bersihkan cache
php artisan optimize:clear

# Reset database + jalankan ulang seeder
php artisan migrate:fresh --seed

# Buat Livewire component baru
php artisan make:livewire NamaComponent

# Buat model + migration sekaligus
php artisan make:model NamaModel -m
```

---

## Catatan

- Gambar dan video disimpan di `storage/app/public`, diakses lewat symlink `public/storage`.
- Payment gateway belum diintegrasikan — sistem masih pakai upload bukti manual. Rencana ke depan pakai Midtrans atau Xendit.
- Untuk deployment production: set `APP_ENV=production`, lalu jalankan `php artisan config:cache` dan `php artisan route:cache`.
- Lihat `DEVELOPER_GUIDE.md` untuk panduan lengkap termasuk troubleshooting umum.
