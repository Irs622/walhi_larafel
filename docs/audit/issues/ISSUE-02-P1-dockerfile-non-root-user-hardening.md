# [P1][SECURITY] Hardening Dockerfile: Jalankan Container dengan Non-Root User (Least Privilege)

**Priority:** P1 (High)  
**Labels:** `priority-p1`, `security`, `hardening`  
**CWE:** CWE-250 (Execution with Unnecessary Privileges)  
**OWASP:** A05:2021 – Security Misconfiguration  

---

## 🐛 Deskripsi Masalah
Pada `Dockerfile` baris 11-77, tidak terdapat deklarasi direktif `USER`. Seluruh proses container (PHP, Artisan, entrypoint script) dieksekusi dengan hak akses **root (UID 0)**.

---

## 💥 Dampak Risiko (Impact)
- Pelanggaran prinsip *Least Privilege* (CWE-250).
- Jika terjadi kerentanan *Remote Code Execution* (RCE) pada ekstensi PHP atau dependensi vendor, penyerang langsung menguasai container sebagai root dan berpotensi melakukan *container breakout* ke host system.

---

## 🛠️ Rekomendasi Solusi
Tambahkan instruksi non-root user `www-data` dan pastikan perizinan folder storage/cache diberikan ke user tersebut:

```dockerfile
# Tambahkan sebelum ENTRYPOINT pada Dockerfile:
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

USER www-data
```

---

## ✅ Kriteria Keberhasilan (Definition of Done)
- [ ] Perintah `docker exec -it walhi_app whoami` mengembalikan `www-data` (bukan `root`).
- [ ] Proses upload gambar, caching Blade, dan pembuatan log tetap berjalan lancar tanpa error *Permission Denied*.
