# Indonesia Luxe - Developer Guide

Panduan lengkap untuk developer yang akan mengembangkan project Indonesia Luxe menggunakan Laravel + Livewire.

---

## 📋 Daftar Isi

1. [Tech Stack](#-tech-stack)
2. [Struktur Folder](#-struktur-folder)
3. [Instalasi](#-instalasi)
4. [Konfigurasi](#-konfigurasi)
5. [Database](#-database)
6. [Fitur Utama](#-fitur-utama)
7. [Color Palette](#-color-palette)
8. [Livewire Components](#-livewire-components)
9. [Routes](#-routes)
10. [Middleware](#-middleware)
11. [Troubleshooting](#-troubleshooting)

---

## 🛠 Tech Stack

| Komponen | Versi | Keterangan |
|----------|-------|------------|
| PHP | 8.2+ | Bahasa utama |
| Laravel | 11.x | Framework PHP |
| Livewire | 3.x | Reactive components |
| Alpine.js | 3.x | Frontend interactions |
| Tailwind CSS | 3.x | Styling (via CDN) |
| MySQL | 8.0+ | Database |
| Vite | 5.x | Build tool |

---

## 📁 Struktur Folder

```
indonesia-luxe-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Controller utama
│   │   ├── Livewire/         # Livewire components
│   │   └── Middleware/       # Custom middleware
│   ├── Models/               # Eloquent models
│   └── Providers/            # Service providers
├── bootstrap/
├── config/
├── database/
│   ├── migrations/           # Semua migration files
│   └── seeders/              # Database seeders
├── public/                   # Web root
│   └── index.php
├── resources/
│   ├── css/                  # Stylesheets
│   ├── js/                   # JavaScript files
│   └── views/                # Blade templates
│       ├── components/       # Reusable components
│       ├── layouts/          # Layout templates
│       ├── livewire/         # Livewire views
│       ├── pages/            # Page views
│       └── sections/         # Page sections
├── routes/
│   └── web.php               # Web routes
├── storage/                  # Storage folder
├── .env.example              # Environment template
├── composer.json             # PHP dependencies
├── package.json              # Node dependencies
└── vite.config.js            # Vite configuration
```

---

## 🚀 Instalasi

### 1. Clone & Install Dependencies

```bash
# Masuk ke folder project
cd indonesia-luxe-laravel

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 2. Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=indonesia_luxe
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3. Setup Database

```bash
# Buat database (jika belum ada)
mysql -u root -p -e "CREATE DATABASE indonesia_luxe;"

# Jalankan migration
php artisan migrate

# Jalankan seeder (untuk data dummy)
php artisan db:seed
```

### 4. Setup Storage Link

```bash
# Buat symbolic link untuk storage
php artisan storage:link
```

### 5. Jalankan Development Server

```bash
# Terminal 1: Jalankan Vite dev server
npm run dev

# Terminal 2: Jalankan Laravel server
php artisan serve
```

Akses website di: `http://localhost:8000`

---

## ⚙️ Konfigurasi

### Email (SMTP)

Edit `.env` untuk konfigurasi email:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@indonesialuxe.com"
MAIL_FROM_NAME="Indonesia Luxe"
```

### File Upload

Pastikan folder storage writable:

```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

---

## 🗄 Database

### Schema Overview

```
users
├── id, name, email, password
├── role (user|vendor|admin)
├── phone, avatar
└── timestamps

categories
├── id, name, slug, icon, image
├── description, is_active
└── timestamps

destinations
├── id, name, slug, image
├── description, is_active
└── timestamps

packages
├── id, vendor_id, category_id, destination_id
├── title, slug, description, short_description
├── duration, price, discounted_price
├── min_travelers, max_travelers
├── inclusions (JSON), itinerary (JSON)
├── gallery (JSON), featured_image
├── location, meeting_point
├── rating, review_count
├── status (draft|active|inactive)
└── timestamps

bookings
├── id, user_id, package_id, vendor_id
├── booking_code, booking_date
├── travel_date, travelers_count
├── total_price, status
├── special_requests
└── timestamps

payments
├── id, booking_id, user_id
├── amount, payment_method
├── payment_proof, status
├── verified_by, verified_at
└── timestamps

reviews
├── id, user_id, package_id, booking_id
├── rating, comment
├── is_approved
└── timestamps

wishlists
├── id, user_id, package_id
└── timestamps
```

### Default Accounts (Setelah Seeder)

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@indonesialuxe.com | password |
| Vendor | vendor@indonesialuxe.com | password |
| User | user@indonesialuxe.com | password |

---

## ✨ Fitur Utama

### User Side

1. **Homepage**
   - Video background hero section
   - Kategori aktivitas
   - Destinasi populer
   - Paket unggulan
   - Testimoni

2. **Search & Filter**
   - Pencarian by keyword
   - Filter by kategori, destinasi, harga
   - Sort by harga, rating

3. **Package Detail**
   - Gallery foto
   - Deskripsi lengkap
   - Itinerary
   - Inclusion/exclusion
   - Reviews
   - Add to cart

4. **Shopping Cart**
   - Multi-booking support
   - Edit tanggal & jumlah traveler
   - Hapus item

5. **Checkout**
   - Form booking
   - Upload bukti pembayaran
   - Pilihan bank transfer

6. **Booking Status**
   - Track status booking
   - Riwayat transaksi
   - Review setelah selesai

### Vendor Dashboard

1. **Tour Management**
   - CRUD paket wisata
   - Upload gallery
   - Set harga & availability

2. **Booking Monitor**
   - Lihat semua booking
   - Update status booking
   - Filter by date/status

3. **Sales Report**
   - Statistik penjualan
   - Grafik pendapatan
   - Export data

### Admin Dashboard

1. **Vendor Approval**
   - Approve/reject vendor
   - Lihat detail vendor

2. **Payment Validation**
   - Verifikasi pembayaran
   - Upload bukti validasi

3. **Transaction Monitor**
   - Semua transaksi
   - Filter & search

4. **Monthly Report**
   - Laporan komprehensif
   - Export PDF/Excel

---

## 🎨 Color Palette

### Primary Colors

```css
--primary-50: #f0f9ff;
--primary-100: #e0f2fe;
--primary-200: #bae6fd;
--primary-300: #7dd3fc;
--primary-400: #38bdf8;
--primary-500: #0ea5e9;    /* Main Primary */
--primary-600: #0284c7;
--primary-700: #0369a1;
--primary-800: #075985;
--primary-900: #0c4a6e;
```

### Secondary Colors

```css
--secondary-50: #fff7ed;
--secondary-100: #ffedd5;
--secondary-200: #fed7aa;
--secondary-300: #fdba74;
--secondary-400: #fb923c;
--secondary-500: #f97316;   /* Main Secondary */
--secondary-600: #ea580c;
--secondary-700: #c2410c;
--secondary-800: #9a3412;
--secondary-900: #7c2d12;
```

### Accent Colors

```css
--accent-50: #f5f3ff;
--accent-100: #ede9fe;
--accent-200: #ddd6fe;
--accent-300: #c4b5fd;
--accent-400: #a78bfa;
--accent-500: #8b5cf6;      /* Main Accent */
--accent-600: #7c3aed;
--accent-700: #6d28d9;
--accent-800: #5b21b6;
--accent-900: #4c1d95;
```

### Neutral Colors

```css
--dark: #0f172a;
--light: #f8fafc;
--gray-50: #f9fafb;
--gray-100: #f3f4f6;
--gray-200: #e5e7eb;
--gray-300: #d1d5db;
--gray-400: #9ca3af;
--gray-500: #6b7280;
--gray-600: #4b5563;
--gray-700: #374151;
--gray-800: #1f2937;
--gray-900: #111827;
```

---

## ⚡ Livewire Components

### Cart Component

```php
// app/Http/Livewire/Cart.php
// Methods:
- addItem($packageId, $date, $travelers)
- removeItem($index)
- updateItem($index, $field, $value)
- clearCart()
- getTotalProperty()
```

### Search Component

```php
// app/Http/Livewire/Search.php
// Properties:
- search, category, destination
- minPrice, maxPrice, sortBy
// Methods:
- applyFilters()
- resetFilters()
- getPackagesProperty()
```

### Checkout Component

```php
// app/Http/Livewire/Checkout.php
// Properties:
- travelDate, travelers, notes
- selectedBank, paymentProof
// Methods:
- processCheckout()
```

### Vendor Dashboard Component

```php
// app/Http/Livewire/Vendor/Dashboard.php
// Properties:
- activeTab, dateRange
// Methods:
- getStatsProperty()
- getBookingsProperty()
```

### Admin Dashboard Component

```php
// app/Http/Livewire/Admin/Dashboard.php
// Properties:
- activeTab, filterStatus
// Methods:
- getStatsProperty()
- getTransactionsProperty()
- verifyPayment($paymentId)
```

---

## 🛣 Routes

### Public Routes

```php
GET  /                    # Homepage
GET  /search              # Search packages
GET  /packages/{slug}     # Package detail
GET  /cart                # Shopping cart
GET  /checkout            # Checkout page
GET  /booking/{code}      # Booking status
```

### Auth Routes (Laravel Breeze/UI)

```php
GET  /login               # Login
GET  /register            # Register
GET  /forgot-password     # Forgot password
GET  /reset-password      # Reset password
```

### User Routes (Authenticated)

```php
GET  /profile             # User profile
GET  /bookings            # Booking history
GET  /wishlist            # Wishlist
POST /reviews             # Submit review
```

### Vendor Routes (Role: vendor)

```php
GET  /vendor/dashboard    # Vendor dashboard
GET  /vendor/tours        # Manage tours
GET  /vendor/tours/create # Create tour
GET  /vendor/tours/{id}/edit  # Edit tour
GET  /vendor/bookings     # Booking monitor
GET  /vendor/reports      # Sales report
```

### Admin Routes (Role: admin)

```php
GET  /admin/dashboard     # Admin dashboard
GET  /admin/vendors       # Vendor approval
GET  /admin/payments      # Payment validation
GET  /admin/transactions  # Transaction monitor
GET  /admin/reports       # Monthly report
```

---

## 🔒 Middleware

### Custom Middleware

| Middleware | Keterangan |
|------------|------------|
| `admin`    | Hanya untuk admin |
| `vendor`   | Hanya untuk vendor |
| `auth`     | Harus login (Laravel default) |
| `guest`    | Hanya untuk guest (Laravel default) |

### Usage

```php
// routes/web.php
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin routes
});

Route::middleware(['auth', 'vendor'])->group(function () {
    // Vendor routes
});
```

---

## 🔧 Troubleshooting

### Common Issues

#### 1. `Class "Livewire" not found`

```bash
composer require livewire/livewire
```

#### 2. `Vite manifest not found`

```bash
npm install
npm run build
```

#### 3. Permission denied pada storage

```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

#### 4. Database connection error

- Cek konfigurasi `.env`
- Pastikan MySQL/MariaDB running
- Buat database manual jika belum ada

#### 5. Class not found errors

```bash
composer dump-autoload
```

#### 6. Cache issues

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

---

## 📞 Support

Jika ada pertanyaan atau issue, silakan hubungi:

- Email: developer@indonesialuxe.com
- WhatsApp: +62 812-3456-7890

---

## 📝 Changelog

### v1.0.0 (2024-02-25)

- Initial release
- Laravel 11 + Livewire 3 setup
- User side: Homepage, Search, Cart, Checkout
- Vendor Dashboard: Tour management, Booking monitor, Sales report
- Admin Dashboard: Vendor approval, Payment validation, Transaction monitor
- Video background hero section
- New color palette (Sky Blue + Sunset Orange)

---

**Selamat mengembangkan! 🚀**
