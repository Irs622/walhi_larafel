# 🏗️ Arsitektur Sistem WALHI Jawa Barat

Dokumen ini menjelaskan struktur arsitektur teknis, pola desain, basis data, dan modul-modul utama dalam aplikasi web **WALHI Jawa Barat**.

---

## 📐 Gambaran Umum (Overview)

Aplikasi WALHI Jawa Barat dibangun menggunakan arsitektur **Monolitik Modern Berbasis Laravel 12** yang menggabungkan kecepatan render server-side (Blade Templating), antarmuka dinamis reaktif (Alpine.js & Tailwind CSS), dan penanganan persistensi data (SQLite untuk local/dev, MySQL/PostgreSQL untuk production).

```
┌─────────────────────────────────────────────────────────────┐
│                       Client Browser                        │
└──────────────────────────────┬──────────────────────────────┘
                               │ HTTPS / HTTP
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                 Nginx / Built-in PHP Server                 │
└──────────────────────────────┬──────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                    Laravel 12 HTTP Kernel                   │
│   ┌─────────────────────────────────────────────────────┐   │
│   │                 Middleware Layer                    │   │
│   │  - Authenticate (Breeze Auth)                       │   │
│   │  - Role / Permission Gates & Policies               │   │
│   │  - CSRF Token & Security Headers                    │   │
│   └──────────────────────────┬──────────────────────────┘   │
│                              ▼                              │
│   ┌─────────────────────────────────────────────────────┐   │
│   │                    Controllers                      │   │
│   │  - Public: HomeController, BlogController, dll      │   │
│   │  - Admin: ContentController, DonationController,dll │   │
│   └──────────┬──────────────────────────────┬───────────┘   │
│              │                              │               │
│              ▼                              ▼               │
│   ┌─────────────────────┐        ┌──────────────────────┐   │
│   │   Blade Views /     │        │   Services Layer     │   │
│   │   Tailwind Frontend │        │ - AuditLogService    │   │
│   └─────────────────────┘        │ - PaymentService     │   │
│                                  └──────────┬───────────┘   │
│                                             │               │
│                                             ▼               │
│   ┌─────────────────────────────────────────────────────┐   │
│   │                  Eloquent Models                    │   │
│   │  - Content, Category, Comment, Donation, AuditLog   │   │
│   └──────────────────────────┬──────────────────────────┘   │
└──────────────────────────────┼──────────────────────────────┘
                               ▼
┌─────────────────────────────────────────────────────────────┐
│              Database (SQLite / MySQL / MariaDB)            │
└─────────────────────────────────────────────────────────────┘
```

---

## 📁 Struktur Direktori Utama

```
walhi_larafel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           # Controller untuk Backoffice CMS
│   │   │   │   ├── ContentController.php
│   │   │   │   ├── DonationController.php
│   │   │   │   ├── PekanRakyatController.php
│   │   │   │   └── ...
│   │   │   ├── Auth/            # Controller Autentikasi Admin & User
│   │   │   └── ...              # Controller Publik (Home, Blog, Donasi, dll)
│   │   └── Middleware/          # Middleware keamanan & otorisasi
│   ├── Models/                  # Eloquent Data Models
│   ├── Policies/                # Authorization Policies (e.g. ContentPolicy)
│   └── Services/                # Service Layer (AuditLogService, dll)
├── database/
│   ├── migrations/              # Definisi skema tabel database
│   └── seeders/                 # Data awal default (User, Konten, Kontak)
├── resources/
│   ├── css/                     # Tailwind CSS entrypoint
│   ├── js/                      # Alpine.js & JavaScript modules
│   └── views/                   # Blade Templates
│       ├── admin/               # Panel admin templates
│       ├── partials/            # Komponen reusable (Header, Footer, Meta SEO)
│       └── ...                  # Halaman publik (Welcome, Tentang Kami, Donasi)
├── public/                      # Static assets (gambar, favicon, build CSS/JS)
├── routes/
│   ├── web.php                  # Web routing publik & backoffice
│   └── auth.php                 # Autentikasi routes
└── docker-entrypoint.sh         # Skrip boot container otomatis
```

---

## 🗄️ Entitas Basis Data Utama

1. **`users`**: Menyimpan akun pengguna dan administrator dengan role-based access.
2. **`contents`**: Modul pusat untuk publikasi:
   - Kategori: *Berita/Blog*, *Siaran Pers*, *Infografis*, *Laporan Tahunan*, *Regulasi*.
   - Atribut: `title`, `slug`, `body`, `excerpt`, `featured_image`, `status (published/archived)`, `views_count`.
3. **`comments`**: Sistem interaksi pembaca pada artikel/rilis publikasi.
4. **`donations`**: Pencatatan donasi online publik (termasuk status transaksi Midtrans / Mock).
5. **`pekan_rakyat`**: Modul khusus kampanye & kegiatan festival lingkungan hidup rakyat.
6. **`audit_logs`**: Pencatatan aktivitas admin secara transparan (*who did what & when*).
7. **`site_contacts`**: Konfigurasi global nomor telepon, email, alamat kantor, dan tautan sosial media.

---

## 🎨 Sistem Desain (Design System)

Platform ini mengadopsi bahasa visual **Neo-Brutalism Hijau Ekologis**:
- **Borders & Shadows**: Border hitam pekat `border-4 border-[#1D1D1D]` dipadukan dengan drop shadow tajam `shadow-[4px_4px_0px_0px_#1D1D1D]`.
- **Warna Utama**:
  - `Forest Green (#256D4A)`: Warna identitas lingkungan & tombol aksi utama.
  - `Sage Green (#5C8D59)`: Warna aksen & hover state.
  - `Warm Cream (#F4F1EA)`: Warna latar belakang utama yang ramah di mata.
  - `Terracotta Red (#D95C3F)`: Warna aksen kampanye & donasi.
  - `Charcoal Dark (#1D1D1D)`: Warna teks, border, dan elemen struktural utama.
- **Tipografi**: Menggunakan kombinasi font display berkarakter kuat (*Anton, Bebas Neue, Oswald*) dan font pembaca modern (*Inter*).

---

## 🔒 Keamanan & Kebijakan Akses

- **CSRF Protection**: Aktif pada seluruh form POST, PUT, DELETE.
- **Role Authorization**: Proteksi route admin menggunakan middleware `auth` dan Policy checks (`$this->authorize(...)`).
- **Audit Logging**: Setiap aksi modifikasi konten atau pengaturan dicatat otomatis di `AuditLogService`.
- **Safe Environment Fallback**: Container Docker mengisolasi konfigurasi sensitif via environment variables yang di-inject saat startup.
