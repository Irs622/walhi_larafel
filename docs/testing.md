# 🧪 Panduan Pengujian Otomatis (Testing Guide)

Dokumen ini memandu pengembang dan AI coding agents dalam menjalankan, memelihara, dan menambahkan pengujian otomatis (*automated tests*) pada platform **WALHI Jawa Barat**.

---

## 1. Ikhtisar Test Suite

Aplikasi dilengkapi rangkaian pengujian otomatis berbasis **PHPUnit** dengan status **100% Lulus**:
- **Total Pengujian:** 109 tests
- **Total Asersi:** 513 assertions
- **Cakupan:** Autentikasi, Otorisasi RBAC, Manajemen Konten, Modul Donasi & Webhook, Keamanan Storage Privat, Validasi URL, Header Keamanan, serta Sanitasi XSS/CSRF/SQLi.

---

## 2. Menjalankan Pengujian

### Perintah Utama:
```bash
# Menjalankan seluruh test suite
php artisan test

# Menjalankan test suite dengan output ringkas
./vendor/bin/phpunit

# Menjalankan test spesifik berdasarkan nama file / class
php artisan test tests/Feature/DocumentStorageTest.php
php artisan test --filter=DocumentStorageTest

# Menjalankan satu skenario method test tertentu
php artisan test --filter=test_public_can_download_published_document
```

---

## 3. Peta Test Suite per Domain

| Test File | Skenario Utama yang Diuji | Jumlah Tests |
| :--- | :--- | :---: |
| **`tests/Feature/DocumentStorageTest.php`** | Isolasi berkas di private storage (SEC-008), otorisasi unduhan draft vs published, proteksi anti open-redirect, resistensi injeksi header CRLF/quotes, kompatibilitas berkas legacy, dan command migrasi. | 12 |
| **`tests/Feature/RbacMatrixTest.php`** | Matriks izin peran Admin vs Editor vs Subscriber, pembatasan kategori sensitif (`donasi`, `kontak`, `kampanye-darurat`), izin aksi hapus, dan penolakan kategori arbitrer pada routing (SEC-007 / SEC-010). | 11 |
| **`tests/Feature/SecurityTest.php`** | Validasi skema URL allowlist & penolakan protocol-relative `//` (SEC-006 / SEC-012), blokir ekstensi berbahaya & MIME spoofing (SEC-011), CSRF protection, CSP nonce injection (SEC-005), rate limiting, sanitasi HTMLPurifier. | 30 |
| **`tests/Feature/DonationTest.php`** | State machine donasi (`pending` → `success`/`failed`/`expired`), penolakan manipulasi status, idempotensi webhook replay, amount mismatch detection, dan proteksi row locking (SEC-009 / SEC-013). | 5 |
| **`tests/Feature/AdminUserCommandTest.php`** | Perintah CLI `walhi:create-admin`, masked secret prompts, penolakan password lemah, dan validasi `PasswordRule::defaults()` (SEC-003 / SEC-004). | 3 |
| **`tests/Feature/AdminTest.php`** | Alur dashboard admin, listing data, filter kategori, aksi toggle status konten, dan penghapusan konten. | 12 |
| **`tests/Feature/PublicContentTest.php`** | Akses halaman beranda, listing blog, detail artikel, paginasi, pencarian, dan penolakan akses draft oleh publik. | 13 |
| **`tests/Feature/CommentSecurityTest.php`** | Pengiriman komentar, honeypot bot trap, validasi parent/child reply, dan moderasi komentar. | 5 |
| **`tests/Feature/SEOAndResponsiveTest.php`** | Respon halaman statis, meta tags OpenGraph/Twitter, validasi file `sitemap.xml` dan `robots.txt`. | 9 |
| **`tests/Feature/ProfileTest.php`** | Pembaruan profil pengguna, email verification state, dan penghapusan akun. | 3 |
| **`tests/Feature/Auth/*`** | Autentikasi kustom `/portal-jabar`, invalid credentials throttle, password reset token, konfirmasi password, dan penonaktifan registrasi publik. | 17 |

---

## 4. Konvensi & Praktik Pembuatan Test Baru

Bagi pengembang atau AI agent yang menambahkan fitur baru:

### A. Gunakan Trait `RefreshDatabase`
Setiap feature test yang berinteraksi dengan database wajib menggunakan:
```php
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeatureTest extends TestCase
{
    use RefreshDatabase;
    ...
}
```

### B. Isolasi Storage dengan `Storage::fake()`
Saat menguji fungsionalitas unggah atau unduh berkas, isolasi storage lokal dan publik agar tidak mengotori disk fisik:
```php
protected function setUp(): void
{
    parent::setUp();
    Storage::fake('local');
    Storage::fake('public');
}
```

### C. Pembuatan Entitas Model
Model `User` memiliki factory:
```php
$admin = User::factory()->create(['role' => 'admin']);
$editor = User::factory()->create(['role' => 'editor']);
```
Untuk model `Content`, gunakan `Content::create([...])` secara eksplisit:
```php
$content = Content::create([
    'title' => 'Judul Berita',
    'slug' => 'judul-berita',
    'category' => ContentCategory::Blog->value,
    'status' => 'published',
]);
```

### D. Simulasi Autentikasi Pengguna
Gunakan helper Laravel `$this->actingAs($user)`:
```php
$response = $this->actingAs($admin)->post('/admin/blog', [...]);
$response->assertSessionHasNoErrors();
```

---

## 5. Mocking Gateway Pembayaran Donasi

1. **Pengujian Lokal / CI:**
   - Gateway Midtrans diuji menggunakan simulasi status dan payload webhook yang ditandatangani dengan algoritma HMAC SHA-512 yang sama persis dengan server resmi Midtrans.
2. **Mock Route:**
   - Route `/donasi/mock-payment-status` hanya dapat dipanggil saat environment adalah `local` atau `testing`.
