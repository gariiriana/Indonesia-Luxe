# 💎 Indonesia Luxe — Premium Tour & Travel Platform

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js)](https://alpinejs.dev)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php)](https://php.net)

Indonesia Luxe adalah platform e-commerce tour & travel premium yang dirancang untuk memberikan pengalaman eksplorasi Nusantara yang elegan dan tak terlupakan. Aplikasi ini berfokus pada estetika **Glassmorphism**, antarmuka pengguna yang hidup dengan micro-animations, serta alur bisnis yang lengkap untuk Wisatawan, Vendor, dan Admin.

---

## ✨ Key Highlights

-   **Premium Aesthetics**: Menggunakan palet warna **Amber-500** yang mewah dikombinasikan dengan efek **Glassmorphism** di seluruh antarmuka.
-   **Immersive Experience**: Hero section dengan slideshow interaktif dan animasi AOS (Animate On Scroll) yang halus.
-   **Responsive Design**: Dioptimalkan secara penuh untuk perangkat mobile (Mobile-First) dan desktop.
-   **Role-Based Access Control**: Sistem yang aman untuk akun Guest, User, Vendor, dan Admin.

---

## 🛠️ Core Technology Stack

| Architecture | Technologies |
| :--- | :--- |
| **Backend Framework** | [Laravel 11](https://laravel.com) |
| **Frontend Rendering** | [Blade Templating Engine](https://laravel.com/docs/blade) |
| **Styling & Design** | [Tailwind CSS](https://tailwindcss.com) (Standard & Custom Glassmorphism UI) |
| **Interactivity** | [Alpine.js](https://alpinejs.dev) for lightweight state management |
| **Icons & Media** | [Lucide Icons](https://lucide.dev) & [Unsplash API](https://unsplash.com) (Premium Assets) |
| **Animations** | [AOS.js](https://michalsnik.github.io/aos/) (Animate on Scroll) |
| **Database** | [MySQL](https://www.mysql.com/) |

---

## 🚀 Fitur Berdasarkan Role

### 👤 Guest (Public)
-   **Discovery**: Jelajahi kategori wisata (Open Trip, Private, Hiking, Snorkeling, etc.).
-   **Smart Search**: Cari destinasi favorit melalui pencarian real-time.
-   **Premium Detail**: Lihat itinerary mendalam, apa yang termasuk dalam paket, dan galeri premium.
-   **Seamless Auth**: Halaman Login & Register dengan desain modern dua-panel.

### 🎒 User (Wisatawan)
-   **Smart Cart**: Kelola beberapa pesanan sebelum checkout.
-   **Booking Management**: Pantau status pesanan (Pending, Verified, Completed).
-   **Wishlist**: Simpan paket impian untuk dipesan nanti.
-   **Loyalty Points**: Dapatkan Luxe Points untuk setiap transaksi sukses.

### 🏢 Vendor (Penyedia Jasa)
-   **Analytics Dashboard**: Pantau total pesanan, paket aktif, dan saldo wallet secara visual.
-   **Package Manager**: Tambah dan kelola paket tour dengan kontrol penuh.
-   **Wallet System**: Kelola pendapatan dan ajukan penarikan dana (Withdrawal).

### 🛡️ Admin (Control Center)
-   **Central Oversight**: Monitoring seluruh statistik transaksi platform.
-   **Verification Engine**: Validasi pembayaran manual (bukti transfer) dan aktivasi vendor.
-   **Inventory Control**: Kelola kategori dan moderasi paket paket tour.

---

## ⚙️ Quick Installation

Pastikan Anda memiliki **PHP 8.2+** dan **Composer** terinstal di sistem Anda.

```bash
# 1. Clone repositori
git clone https://github.com/gariiriana/Indonesia-Luxe.git
cd Indonesia-Luxe

# 2. Install dependencies
composer install
npm install && npm run build

# 3. Setup Environment
cp .env.example .env
php artisan key:generate

# 4. Database Setup (Konfigurasi .env sesuai DB lokal Anda)
php artisan migrate --seed
php artisan storage:link

# 5. Launch
php artisan serve
```

---

## 🎨 Design System

Proyek ini telah melalui tahap optimasi visual untuk menyamai standar **Figma High-Fidelity Prototype**:
-   **Typography**: `Inter` untuk kejelasan data, `Playfair Display` untuk nuansa mewah di judul.
-   **Spacing**: Mengikuti metrik 4-grid untuk harmoni visual.
-   **Glassmorphism**: Implementasi `backdrop-blur` dan `border-white/20` pada komponen navigasi dan kartu.

---

<p align="center">Made with ❤️ for Indonesia Tourism</p>
