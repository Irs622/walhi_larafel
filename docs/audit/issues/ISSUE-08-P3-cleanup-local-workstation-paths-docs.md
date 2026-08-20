# [P3][DOCS] Bersihkan Tautan Absolut Workstation Lokal Pengembang pada Dokumen SECURITY.md

**Priority:** P3 (Informational / Cleanup)  
**Labels:** `priority-p3`, `documentation`  
**CWE:** CWE-200 (Exposure of Sensitive Information to an Unauthorized Actor)  

---

## 🐛 Deskripsi Masalah
Pada baris 55 file `SECURITY.md`, terdapat tautan markdown absolut:
`[bootstrap/app.php](file:///Users/mac/clone%20walhi/walhi_larafel/bootstrap/app.php)` yang membocorkan path workstation lokal pengembang.

---

## 🛠️ Rekomendasi Solusi
Ganti tautan tersebut menjadi path relatif: `bootstrap/app.php`.

---

## ✅ Kriteria Keberhasilan (Definition of Done)
- [ ] Tidak ada referensi path workstation lokal pengembang pada seluruh berkas markdown repositori.
