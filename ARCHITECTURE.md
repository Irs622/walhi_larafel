# 🏗️ Arsitektur Sistem WALHI Jawa Barat

Dokumen ini menjelaskan struktur arsitektur teknis, pola desain, basis data, dan modul-modul utama dalam aplikasi web **WALHI Jawa Barat**.

---

## 📐 Gambaran Umum (Overview)

Aplikasi WALHI Jawa Barat dibangun menggunakan arsitektur **Monolitik Modern Berbasis Laravel 13** yang menggabungkan kecepatan render server-side (Blade Templating), antarmuka dinamis reaktif (Alpine.js & Tailwind CSS), dan penanganan persistensi data (SQLite untuk local/tests, MySQL untuk production).

```text
┌─────────────────────────────────────────────────────────────┐
│                       Client Browser                        │
└──────────────────────────────┬──────────────────────────────┘
                               │ HTTPS / HTTP
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                 Nginx / Built-in PHP Server                 │
│  - SSL Termination & Strict MIME-type Handling              │
│  - Script Execution Block in /storage/                      │
└──────────────────────────────┬──────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                  Laravel 13 Application                     │
│   ┌─────────────────────────────────────────────────────┐   │
│   │                 Middleware Layer                    │   │
│   │  - TrustProxies & TrustHosts                        │   │
│   │  - SecurityHeaders (Dynamic CSP Nonce & NoSniff)    │   │
│   │  - CheckRole (RBAC: Admin, Editor, Subscriber)      │   │
│   │  - CSRF Token Validation (Exempt: donasi/webhook)   │   │
│   └──────────────────────────┬──────────────────────────┘   │
│                              ▼                              │
│   ┌─────────────────────────────────────────────────────┐   │
│   │                    Controllers                      │   │
│   │  - Public: PublicContentController, PageController  │   │
│   │  - Download: DocumentDownloadController (SEC-008)   │   │
│   │  - Admin: ContentController, AdminCommentController │   │
│   │  - Auth: AuthenticatedSessionController             │   │
│   │  - Donation: DonationController                     │   │
│   └──────────┬──────────────────────────────┬───────────┘   │
│              │                              │               │
│              ▼                              ▼               │
│   ┌─────────────────────┐        ┌──────────────────────┐   │
│   │   Blade Views /     │        │   Services Layer     │   │
│   │   Tailwind + Alpine │        │ - DonationService    │   │
│   │                     │        │ - MidtransService    │   │
│   │                     │        │ - SlugService        │   │
│   │                     │        │ - AuditLogService    │   │
│   └─────────────────────┘        └──────────┬───────────┘   │
│                                             │               │
│                                             ▼               │
│   ┌─────────────────────────────────────────────────────┐   │
│   │                  Eloquent Models                    │   │
│   │  - Content, Comment, Donation, Subscriber, User     │   │
│   │  - Enums: ContentCategory, ContentStatus,           │   │
│   │           DonationStatus, UserRole                  │   │
│   └──────────────────────────┬──────────────────────────┘   │
│                              │                              │
│              ┌───────────────┴───────────────┐              │
│              ▼                               ▼              │
│   ┌─────────────────────┐        ┌──────────────────────┐   │
│   │   Database Layer    │        │    Storage Layer     │   │
│   │   (SQLite / MySQL)  │        │ - Local: Private Docs│   │
│   │                     │        │ - Public: Media/Img  │   │
│   └─────────────────────┘        └──────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

---

## 📁 Struktur Direktori Utama

```text
walhi_larafel/
├── app/
│   ├── Console/Commands/        # CLI commands (walhi:create-admin, walhi:migrate-documents)
│   ├── Enums/                   # Enums (ContentCategory, ContentStatus, DonationStatus, UserRole)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           # Backoffice CMS (ContentController, AdminCommentController, AdminSubscriberController, AdminController)
│   │   │   ├── Auth/            # Breeze auth (AuthenticatedSessionController, PasswordReset, etc.)
│   │   │   ├── PublicContentController.php # Beranda, Blog, dan Detail Konten publik
│   │   │   ├── PageController.php          # Halaman statis/publikasi (Regulasi, Laporan, Donasi, dll.)
│   │   │   ├── DocumentDownloadController.php # SEC-008: Unduhan dokumen privat terotorisasi
│   │   │   ├── DonationController.php      # Checkout donasi & webhook Midtrans
│   │   │   ├── CommentController.php       # Form komentar artikel publik
│   │   │   └── SubscriptionController.php  # Pendaftaran newsletter
│   │   ├── Middleware/          # SecurityHeaders, CheckRole
│   │   └── Requests/            # FormRequest input validation rules
│   ├── Models/                  # Eloquent Models (Content, Comment, Donation, Subscriber, User)
│   ├── Policies/                # ContentPolicy (viewAny, view, create, update, delete)
│   └── Services/                # Service Layer (DonationService, MidtransService, SlugService, AuditLogService)
├── bootstrap/
│   └── app.php                  # Konfigurasi routing, global middleware, trust proxies, CSRF, exception rendering
├── config/                      # Konfigurasi aplikasi, filesystems, session, database
├── database/
│   ├── migrations/              # Definisi skema tabel database
│   └── seeders/                 # Data awal default (User, Konten, Kontak)
├── docs/                        # Dokumentasi teknis mendalam untuk developer & AI coding agents
│   ├── domain-rules.md          # Invariant bisnis dan siklus hidup data
│   ├── database.md              # Skema tabel, casting, dan relasi
│   ├── frontend.md              # Panduan desain Neo-Brutalisme & Blade/Alpine
│   └── testing.md               # Peta test suite otomatis
├── resources/
│   ├── css/app.css              # Entrypoint styling Tailwind CSS & tipografi
│   ├── js/app.js                # Inisialisasi Alpine.js
│   └── views/                   # Blade Templates (admin/, partials/, layouts/, public pages)
├── routes/
│   ├── web.php                  # Web routing publik & backoffice
│   └── auth.php                 # Autentikasi routes (/portal-jabar)
└── storage/
    ├── app/
    │   ├── private/documents/   # SEC-008: Dokumen organisasi privat (PDF, DOC, XLS)
    │   └── public/uploads/      # Media gambar publik yang di-symlink ke public/storage
    └── logs/                    # Log sistem & Audit Trail harian
```

---

## 🗄️ Entitas Basis Data & Model Aktual

Aplikasi menggunakan 5 model Eloquent utama dengan dukungan PHP Enums:

1. **`users` (`User`)**: Akun pengguna dan administrator dengan role-based access (`admin`, `editor`, `subscriber`).
2. **`contents` (`Content`)**: Tabel tunggal polimorfik untuk seluruh publikasi dan konfigurasi berbasis kategori:
   - Kategori dikelola via Enum `App\Enums\ContentCategory` (20 kasus kategori terdaftar: Publikasi, Dokumen Resmi, Terbitan Berkala, Profil Organisasi, Kampanye/Pekan Rakyat, Beranda).
   - Status dikelola via Enum `App\Enums\ContentStatus` (`published`, `draft`, `archived`).
   - Dokumen privat disimpan di disk `local` (`storage/app/private/documents/`), sedangkan gambar di disk `public` (`storage/app/public/uploads/`).
3. **`comments` (`Comment`)**: Interaksi komentar bertingkat (parent/child) pada artikel konten dengan status `pending`, `approved`, `spam`.
4. **`donations` (`Donation`)**: Catatan transaksi donasi online dengan state machine ketat `App\Enums\DonationStatus` (`pending`, `success`, `failed`, `expired`).
5. **`subscribers` (`Subscriber`)**: Daftar email pelanggan newsletter WALHI dengan sanitasi export CSV anti-formula injection.

> [!NOTE]
> **Audit Trail & Konfigurasi Organisasi:**  
> - **Audit Trail** tidak menggunakan tabel database, melainkan dicatat secara terstruktur ke log harian via `App\Services\AuditLogService::log()` (`LOG_CHANNEL=daily`).  
> - **Pekan Rakyat & Kontak Organisasi** disimpan di dalam tabel `contents` menggunakan kategori khusus (`pekan-rakyat` dan `kontak`).

---

## 🎨 Sistem Desain (Design System)

Platform ini mengadopsi bahasa visual **Neo-Brutalism Hijau Ekologis**:
- **Borders & Shadows**: Border hitam tebal `border-2 border-[#1D1D1D]` atau `border-4 border-[#1D1D1D]` dipadukan dengan drop shadow tajam `shadow-[4px_4px_0px_0px_#1D1D1D]`.
- **Warna Utama**:
  - `Forest Green (#256D4A)`: Warna identitas lingkungan & tombol aksi utama.
  - `Sage Green (#5C8D59)`: Warna aksen & hover state.
  - `Warm Cream (#F4F1EA)`: Warna latar belakang utama ramah di mata.
  - `Terracotta Red (#D95C3F)`: Warna aksen kampanye & donasi.
  - `Charcoal Dark (#1D1D1D)`: Warna teks, border, dan elemen struktural utama.
- **Tipografi**:
  - Headline/Display: Font `Aspekta` (uppercase, bold, letter-spacing tegas).
  - Body/Narrative: Font `Montserrat` (clean, modern, highly readable).

---

## 🔒 Keamanan & Kebijakan Akses

- **CSRF Protection**: Aktif pada seluruh form mutasi data (`POST`, `PUT`, `DELETE`). Hanya `donasi/webhook` yang dikecualikan di `bootstrap/app.php`.
- **Role Authorization**: RBAC bertingkat (`admin`, `editor`, `subscriber`) ditegakkan melalui middleware `role:` dan `ContentPolicy`. Kategori sensitif (`donasi`, `kontak`, `kampanye-darurat`) dibatasi eksklusif untuk Admin.
- **Document Isolation (SEC-008)**: Berkas dokumen non-gambar disimpan pada private local storage (`storage/app/private/documents/`) dan hanya dapat diunduh melalui `DocumentDownloadController` berotorisasi dengan header `nosniff` dan `Content-Disposition: attachment`.
- **Protocol-Relative & URL Allowlist (SEC-006)**: Validasi input menolak `//` dan `///` serta skema `javascript:`, `data:`, `vbscript:`.
- **CSP Nonce (SEC-005)**: Header `Content-Security-Policy` menginjeksi nonce kriptografis per-request ke direktif `script-src`.
- **Audit Logging**: Aksi administratif (`CONTENT_CREATE`, `CONTENT_UPDATE`, `CONTENT_DELETE`, `COMMENT_APPROVE`, dll.) dicatat otomatis melalui `AuditLogService`.
- **Database Hardening**: `APP_DEBUG=false` di produksi; exception query database disanitasi di `bootstrap/app.php` tanpa membocorkan skema tabel ke UI.
