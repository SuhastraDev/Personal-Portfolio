<p align="center">
  <img src="public/images/logo.png" width="120" alt="SuhastraDev Logo">
</p>

<h1 align="center">SuhastraDev</h1>

<p align="center">
  <strong>Portfolio Website & Source Code Marketplace</strong><br>
  Dibangun dengan Laravel 12 · Livewire · Tailwind CSS · Midtrans Payment
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-red?logo=laravel" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue?logo=php" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Livewire-4-pink?logo=livewire" alt="Livewire 4">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3-38B2AC?logo=tailwindcss" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Midtrans-Payment-orange" alt="Midtrans">
</p>

---

## 📋 Tentang

**SuhastraDev** adalah website portfolio developer sekaligus marketplace source code yang dibangun menggunakan Laravel 12. Website ini menampilkan portofolio proyek, layanan yang ditawarkan, serta menjual produk source code dengan integrasi pembayaran Midtrans.

### ✨ Fitur Utama

**🌐 Frontend (Public)**

- **Landing Page** — Hero section, skills, portofolio unggulan, testimonial, kontak
- **Halaman Portfolio** — Galeri proyek dengan filter kategori & detail proyek
- **Marketplace Produk** — Katalog source code dengan filter kategori & tag
- **Checkout & Pembayaran** — Integrasi Midtrans Snap (GoPay, OVO, Bank Transfer, dll.)
- **Download Otomatis** — Token-based download link dengan expiry & limit
- **Halaman Layanan** — Daftar jasa yang ditawarkan
- **Tentang & Kontak** — Halaman profil developer & form kontak
- **Multi-bahasa** — Dukungan Indonesia 🇮🇩 & English 🇬🇧
- **SEO Optimized** — Meta title, description, Open Graph tags
- **SPA Navigation** — Navigasi tanpa reload menggunakan Livewire `wire:navigate`
- **Animasi AOS** — Animate On Scroll untuk pengalaman visual yang menarik

**🔐 Admin Panel**

- **Dashboard** — Statistik ringkas (produk, order, portofolio, pesan) + revenue dari Midtrans
- **Manajemen Portfolio** — CRUD portofolio dengan multiple images & kategori
- **Manajemen Produk** — CRUD source code dengan upload file, gambar, kategori & tag
- **Manajemen Order** — Kelola pesanan, update status pembayaran
- **Manajemen Layanan** — CRUD jasa/layanan
- **Skill & Testimonial** — Kelola kemampuan teknis & testimoni klien
- **Kontak Masuk** — Lihat & kelola pesan dari pengunjung
- **Pengaturan Website** — Konfigurasi situs (nama, deskripsi, sosial media, dll.)
- **Ubah Password** — Ganti password admin dari panel
- **Konten Multi-bahasa** — Translasi konten Indonesia ↔ English

**🔒 Keamanan & Auth**

- **Login Admin** — Laravel Breeze authentication
- **Lupa Password dengan OTP** — Kirim kode OTP 6 digit via email (10 menit expiry)
- **Rate Limiting** — Proteksi brute-force pada checkout & auth
- **CSRF Protection** — Perlindungan bawaan Laravel
- **Midtrans Webhook** — Verifikasi signature hash untuk keamanan callback

---

## 🛠️ Tech Stack

| Layer                | Teknologi                             |
| -------------------- | ------------------------------------- |
| **Framework**        | Laravel 12                            |
| **PHP**              | 8.2+                                  |
| **Frontend**         | Tailwind CSS 3, Alpine.js, Livewire 4 |
| **Build Tool**       | Vite 7                                |
| **Payment**          | Midtrans Snap API                     |
| **Image Processing** | Intervention Image                    |
| **Icons**            | Font Awesome 7                        |
| **Animasi**          | AOS (Animate On Scroll)               |
| **Database**         | MySQL / SQLite                        |
| **Email**            | SMTP (Mailtrap untuk dev)             |

---

## 📦 Instalasi

### Prasyarat

- PHP 8.2 atau lebih baru
- Composer
- Node.js 18+ & NPM
- MySQL / MariaDB (atau SQLite)
- Laragon / XAMPP / Herd (untuk Windows)

### Langkah Instalasi

**1. Clone repository**

```bash
git clone https://github.com/SuhastraDev/Personal-Portfolio.git
cd SuhastraDev
```

**2. Install dependencies**

```bash
composer install
npm install
```

**3. Konfigurasi environment**

```bash
cp .env.example .env
php artisan key:generate
```

**4. Konfigurasi `.env`**

Sesuaikan file `.env` dengan pengaturan lokal Anda:

```env
APP_NAME=SuhastraDev
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=suhastradev
DB_USERNAME=root
DB_PASSWORD=

# Mail (gunakan Mailtrap untuk development)
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_FROM_ADDRESS="noreply@suhastradev.com"
MAIL_FROM_NAME="${APP_NAME}"

# Midtrans
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

**5. Migrasi database**

```bash
php artisan migrate
```

**6. Buat symbolic link untuk storage**

```bash
php artisan storage:link
```

**7. Build assets frontend**

```bash
npm run build
```

**8. Jalankan development server**

```bash
# Terminal 1 — Laravel server
php artisan serve

# Terminal 2 — Vite dev server (Hot Reload)
npm run dev
```

Buka `http://localhost:8000` di browser.

---

## 🗄️ Struktur Database

| Tabel                  | Keterangan                     |
| ---------------------- | ------------------------------ |
| `users`                | Admin users                    |
| `settings`             | Pengaturan website (key-value) |
| `skills`               | Kemampuan teknis               |
| `testimonials`         | Testimoni klien                |
| `portfolio_categories` | Kategori portofolio            |
| `portfolios`           | Proyek portofolio              |
| `portfolio_images`     | Gambar galeri portofolio       |
| `portfolio_category`   | Pivot portofolio ↔ kategori    |
| `product_categories`   | Kategori produk                |
| `product_tags`         | Tag produk                     |
| `products`             | Source code / produk digital   |
| `product_images`       | Gambar galeri produk           |
| `product_tag`          | Pivot produk ↔ tag             |
| `orders`               | Pesanan & transaksi pembayaran |
| `services`             | Jasa/layanan                   |
| `contacts`             | Pesan kontak masuk             |
| `password_reset_otps`  | OTP untuk reset password       |

---

## 📁 Struktur Proyek

```
SuhastraDev/
├── app/
│   ├── Helpers/            # Helper functions
│   ├── Http/Controllers/
│   │   ├── Admin/          # Controller panel admin
│   │   └── Auth/           # Controller autentikasi (login, OTP, reset)
│   ├── Livewire/           # Komponen Livewire
│   ├── Mail/               # Mailable (OTP email)
│   ├── Models/             # Eloquent models
│   └── Traits/             # HasTranslation trait
├── config/
│   └── midtrans.php        # Konfigurasi Midtrans
├── database/
│   └── migrations/         # Migrasi database
├── lang/                   # File bahasa (id/en)
├── public/
│   ├── images/             # Gambar statis (logo, dll.)
│   └── build/              # Asset hasil Vite build
├── resources/
│   └── views/
│       ├── admin/          # View halaman admin
│       ├── auth/           # View login, OTP, reset password
│       ├── emails/         # Template email
│       ├── layouts/        # Layout (app, admin, guest)
│       └── pages/          # Halaman publik (home, portfolio, produk, dll.)
├── routes/
│   ├── web.php             # Route publik & admin
│   └── auth.php            # Route autentikasi
└── ...
```

---

## ⚙️ Perintah Berguna

```bash
# Menjalankan migration
php artisan migrate

# Membersihkan cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Optimize untuk production
php artisan optimize

# Build assets production
npm run build

# Development mode (hot reload)
npm run dev

# Melihat daftar route
php artisan route:list
```

---

## 🔑 Akses Admin

Setelah instalasi, buat akun admin melalui tinker:

```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@suhastradev.com',
    'password' => bcrypt('password'),
    'is_admin' => true,
]);
```

Akses panel admin di: `http://localhost:8000/admin`

---

## 💳 Konfigurasi Midtrans

1. Buat akun di [Midtrans Dashboard](https://dashboard.midtrans.com)
2. Dapatkan **Server Key** dan **Client Key** dari menu Settings → Access Keys
3. Masukkan key ke file `.env`
4. Set **Payment Notification URL** di Midtrans Dashboard ke: `https://yourdomain.com/midtrans/webhook`
5. Untuk testing gunakan mode **Sandbox**

---

## 🌐 Deployment

### Production Checklist

- [ ] Set `APP_ENV=production` dan `APP_DEBUG=false`
- [ ] Set `APP_URL` ke domain yang sesuai
- [ ] Konfigurasi database production
- [ ] Set Midtrans ke mode production (`MIDTRANS_IS_PRODUCTION=true`)
- [ ] Konfigurasi SMTP email production
- [ ] Jalankan `php artisan optimize`
- [ ] Jalankan `npm run build`
- [ ] Set permission folder `storage/` dan `bootstrap/cache/`
- [ ] Konfigurasi web server (Nginx/Apache)
- [ ] Setup SSL certificate (HTTPS)
- [ ] Set webhook URL Midtrans ke domain production

---

## 📝 Lisensi

Proyek ini bersifat **private** dan hanya untuk penggunaan pribadi SuhastraDev.

---

<p align="center">
  Dibuat dengan ❤️ oleh <strong>SuhastraDev</strong>
</p>
