# [P3][BUG] Ganti Pemanggilan env() Langsung pada AdminUserSeeder dengan Helper config()

**Priority:** P3 (Low)  
**Labels:** `priority-p3`, `bug`, `backend`  
**CWE:** CWE-1188 (Insecure Default Initialization of Resource)  

---

## 🐛 Deskripsi Masalah
Pada `database/seeders/AdminUserSeeder.php` baris 17-18:
```php
$adminEmail = env('ADMIN_EMAIL') ?: 'admin@walhi-jabar.org';
$adminPass = env('ADMIN_' . 'PASSWORD') ?: Str::random(16);
```
Di Laravel, setelah perintah `php artisan config:cache` dijalankan pada lingkungan produksi, pemanggilan `env()` di luar file konfigurasi akan selalu mengembalikan `null`.

---

## 💥 Dampak Risiko (Impact)
- Jika seeder dijalankan pada server yang konfigurasinya sudah di-cache, seeder akan selalu membuat password acak `Str::random(16)` yang tidak diketahui admin, sehingga admin terkunci (*lockout*).

---

## 🛠️ Rekomendasi Solusi
Daftarkan konfigurasi kredensial default admin di `config/auth.php`:
```php
'admin_seed' => [
    'email' => env('ADMIN_EMAIL', 'admin@walhi-jabar.org'),
    'password' => env('ADMIN_PASSWORD'),
],
```
Dan panggil melalui helper `config()` di `AdminUserSeeder.php`:
```php
$adminEmail = config('auth.admin_seed.email');
$adminPass  = config('auth.admin_seed.password') ?: Str::random(16);
```

---

## ✅ Kriteria Keberhasilan (Definition of Done)
- [ ] `php artisan db:seed --class=AdminUserSeeder` berfungsi normal saat `config:cache` aktif.
