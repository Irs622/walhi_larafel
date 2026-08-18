# 🤝 Panduan Kontribusi (Contributing Guidelines)

Terima kasih telah tertarik untuk berkontribusi pada proyek pengembangan website resmi **WALHI Jawa Barat**! Dokumen ini berisi panduan alur kerja (*workflow*), standar kode, dan langkah-langkah kolaborasi bagi seluruh anggota tim dan kontributor terbuka.

---

## 📋 Daftar Isi
1. [Alur Kerja Git & Percabangan (Branching Workflow)](#-alur-kerja-git--percabangan)
2. [Konvensi Pesan Komit (Commit Conventions)](#-konvensi-pesan-komit)
3. [Standar Kode (Coding Standards)](#-standar-kode)
4. [Langkah Membuat Pull Request (PR)](#-langkah-membuat-pull-request)
5. [Menjalankan Pengujian (Testing)](#-menjalankan-pengujian)
6. [Pelaporan Masalah (Reporting Issues)](#-pelaporan-masalah)

---

## 🌿 Alur Kerja Git & Percabangan

Branch utama proyek ini adalah `main`. Semua pengembangan fitur dan perbaikan bug harus dilakukan pada branch terpisah sebelum digabungkan (*merged*) ke `main` melalui Pull Request.

### Format Penamaan Branch:
- `feat/nama-fitur` : Untuk penambahan fitur baru (contoh: `feat/payment-gateway-midtrans`).
- `fix/nama-perbaikan` : Untuk perbaikan bug atau error (contoh: `fix/tentang-kami-tabs`).
- `refactor/nama-refactor` : Untuk restrukturisasi kode tanpa mengubah fungsionalitas (contoh: `refactor/audit-log-service`).
- `docs/nama-dokumen` : Untuk pembaruan dokumentasi (contoh: `docs/api-documentation`).
- `style/nama-styling` : Untuk penyesuaian tampilan CSS/Tailwind (contoh: `style/neo-brutalist-card`).

---

## 💬 Konvensi Pesan Komit

Kami menggunakan standar [Conventional Commits](https://www.conventionalcommits.org/) agar riwayat perubahan (*git history*) rapi dan mudah ditelusuri.

Format:
```
<type>(<scope optional>): <deskripsi singkat jelas>
```

Contoh:
- `feat(donasi): tambahkan filter riwayat donasi berdasarkan tanggal`
- `fix(tabs): perbaiki active state pada tab navigasi tentang kami`
- `docs(readme): tambahkan panduan instalasi docker`
- `refactor(auth): perbarui middleware pemeriksaan role admin`

Daftar `type`:
- `feat` : Fitur baru untuk pengguna.
- `fix` : Perbaikan bug.
- `docs` : Perubahan dokumentasi saja.
- `style` : Formatting kode, whitespace, titik koma (tidak mengubah logika).
- `refactor` : Refactoring kode tanpa menambah fitur baru atau memperbaiki bug.
- `test` : Menambahkan atau memperbarui unit/feature tests.
- `chore` : Pembaruan build scripts, dependencies, konfigurasi CI/CD.

---

## 🎨 Standar Kode

### 1. PHP (Laravel)
- Mengikuti standar **PSR-12** (Coding Style Guide).
- Gunakan *Type Hinting* dan *Return Types* pada setiap method controller dan service.
- Logika bisnis yang kompleks dipisahkan ke dalam **Service Classes** (misal `app/Services/AuditLogService.php`), bukan menumpuk di Controller.
- Gunakan **Form Request Validation** atau `$request->validate([...])` untuk semua input pengguna.

### 2. Blade & Frontend
- Gunakan **Tailwind CSS** untuk utility styling.
- Pertahankan tema desain **Neo-Brutalist WALHI** (border hitam tegas `#1D1D1D`, bayangan blok `shadow-[4px_4px_0px_0px_#1D1D1D]`, palet warna hijau hutan `#256D4A`, krem `#F4F1EA`, dan oranye terakota `#D95C3F`).
- Hindari penggunaan CDN eksternal jika memungkinkan; gunakan **native inline SVG** untuk ikon agar tidak ada kegagalan rendering saat koneksi offline/lambat.

---

## 🚀 Langkah Membuat Pull Request

1. **Fork atau Clone Repository:**
   ```bash
   git clone https://github.com/Irs622/walhi_larafel.git
   cd walhi_larafel
   ```

2. **Buat Branch Baru:**
   ```bash
   git checkout -b feat/nama-fitur-kamu
   ```

3. **Lakukan Perubahan & Uji di Lingkungan Lokal:**
   ```bash
   docker compose up -d --build
   ```

4. **Komit Perubahan Anda:**
   ```bash
   git add .
   git commit -m "feat(konten): tambahkan filter kategori artikel"
   ```

5. **Push ke GitHub:**
   ```bash
   git push -u origin feat/nama-fitur-kamu
   ```

6. **Buat Pull Request (PR):**
   - Buka repository di GitHub dan klik tombol **New Pull Request**.
   - Isi form PR sesuai template yang telah disediakan (deskripsikan apa yang diubah dan bagaimana cara mengujinya).
   - Minta review dari setidaknya 1 rekan tim sebelum melakukan merge ke `main`.

---

## 🧪 Menjalankan Pengujian

Sebelum mengajukan PR, pastikan semua tes lokal berjalan tanpa error:

```bash
# Menjalankan PHPUnit Feature & Unit Tests
php artisan test

# Atau jalankan di dalam container Docker
docker compose exec app php artisan test
```

---

## 🐞 Pelaporan Masalah (Issues)

Jika Anda menemukan bug, error, atau memiliki usulan fitur baru:
1. Periksa tab **Issues** untuk memastikan isu serupa belum pernah dilaporkan.
2. Buat Issue baru dengan memilih template yang sesuai (*Bug Report* atau *Feature Request*).
3. Sertakan langkah-langkah reproduksi error (*steps to reproduce*), screenshot/log, dan spesifikasi lingkungan (OS, versi Docker/PHP).
