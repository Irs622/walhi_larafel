# [P3][SECURITY] Terapkan Fail-Safe Defaults untuk APP_DEBUG & SESSION_SECURE_COOKIE di docker-entrypoint.sh

**Priority:** P3 (Low)  
**Labels:** `priority-p3`, `security`, `hardening`  
**CWE:** CWE-1188 (Insecure Default Initialization of Resource)  

---

## 🐛 Deskripsi Masalah
Pada `docker-entrypoint.sh` baris 35 & 63:
```bash
APP_DEBUG=${APP_DEBUG:-true}
SESSION_SECURE_COOKIE=${SESSION_SECURE_COOKIE:-false}
```
Jika variabel environment tidak didefinisikan secara eksplisit, entrypoint menetapkan mode debug aktif (`true`) dan cookie insecure (`false`).

---

## 🛠️ Rekomendasi Solusi
Ubah nilai default agar selalu mengacu pada prinsip *Fail-Safe Defaults*:
```bash
APP_DEBUG=${APP_DEBUG:-false}
SESSION_SECURE_COOKIE=${SESSION_SECURE_COOKIE:-true}
```

---

## ✅ Kriteria Keberhasilan (Definition of Done)
- [ ] Container yang distart tanpa env variabel otomatis berjalan dengan `APP_DEBUG=false` dan `SESSION_SECURE_COOKIE=true`.
