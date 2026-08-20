# [P0][SECURITY] Ganti Single-Threaded 'php artisan serve' dengan PHP-FPM pada Dockerfile Produksi

**Priority:** P0 (Critical - Blocker)  
**Labels:** `priority-p0`, `security`, `hardening`, `backend`  
**CWE:** CWE-400 (Uncontrolled Resource Consumption)  
**OWASP:** A05:2021 – Security Misconfiguration  

---

## 🐛 Deskripsi Masalah
Container aplikasi pada `Dockerfile` baris 76 saat ini dikonfigurasi menjalankan perintah:
```dockerfile
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
```
Dan di-proxy oleh Nginx pada `docker/nginx/default.conf` baris 54-62:
```nginx
location ~ \.php$ {
    proxy_pass http://app:8000;
}
```
`php artisan serve` menggunakan built-in CLI server PHP (`php -S`) yang bersifat **single-threaded dan blocking**. Di lingkungan produksi, server ini tidak mampu menangani lebih dari 1 request secara bersamaan.

---

## 💥 Dampak Risiko (Impact)
- **Denial of Service (DoS):** Akses simultan dari 5–10 pengguna atau adanya request lambat (seperti ekspor CSV/webhook) akan mengunci seluruh thread PHP.
- Pengguna publik lainnya akan mengalami *hang* dan menerima pesan error `504 Gateway Timeout`.

---

## 🛠️ Rekomendasi Solusi
1. Ganti base image Stage 2 `Dockerfile` menjadi `php:8.4-fpm-alpine`.
2. Ubah `CMD` default menjadi `["php-fpm"]` dengan port `9000`.
3. Konfigurasi Nginx `docker/nginx/default.conf` menggunakan protokol FastCGI (`fastcgi_pass app:9000`).

```nginx
location ~ \.php$ {
    fastcgi_pass app:9000;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    include fastcgi_params;
    fastcgi_read_timeout 300;
}
```

---

## ✅ Kriteria Keberhasilan (Definition of Done)
- [ ] Container app menggunakan `php-fpm` dan melayani request via FastCGI di port 9000.
- [ ] Dilakukan uji beban konkuren minimal 50 concurrent requests tanpa ada request yang drop/timeout.
