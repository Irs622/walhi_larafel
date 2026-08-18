## 📌 Deskripsi Perubahan
<!-- Jelaskan secara ringkas perubahan apa yang dibuat, latar belakang, dan tujuan dari perubahan tersebut. -->

## 🔗 Issue Terkait
<!-- Contoh: Fixes #12, Closes #45, atau Tulis 'N/A' jika tidak ada -->
Fixes #

## 🔍 Tipe Perubahan
<!-- Beri tanda centang [x] pada opsi yang sesuai -->
- [ ] 🐛 **Perbaikan Bug** (*Bug fix yang menyelesaikan masalah*)
- [ ] ✨ **Fitur Baru** (*Penambahan fungsionalitas baru*)
- [ ] 🎨 **Perubahan Tampilan / Styling** (*Penyesuaian UI / UX / CSS*)
- [ ] ⚡ **Optimasi Performa** (*Peningkatan performa aplikasi / query*)
- [ ] 📝 **Dokumentasi** (*Pembaruan README / panduan / komentar kode*)
- [ ] ♻️ **Refactoring Kode** (*Restrukturisasi kode tanpa mengubah fungsionalitas*)
- [ ] 🔒 **Pembaruan Keamanan** (*Security patch*)

## 🧪 Langkah Pengujian (Testing Steps)
<!-- Jelaskan langkah-langkah konkret untuk menguji perubahan ini di lingkungan lokal -->
1. Jalankan `docker compose up -d --build` (atau `php artisan serve`)
2. Buka URL: `http://localhost:8000/...`
3. Lakukan langkah: ...
4. Hasil yang diharapkan: ...

## 📸 Bukti Pengujian / Screenshot (Wajib untuk perubahan UI)
<!-- Sisipkan tangkapan layar / GIF / video singkat yang membuktikan fitur berjalan dengan baik -->

## 📋 Checklist Kepatuhan Aturan PR
<!-- Pastikan Anda telah memenuhi seluruh ketentuan berikut sebelum meminta review -->
- [ ] **Fokus Tunggal**: PR ini hanya membahas 1 topik/fitur (*tidak mencampur banyak hal yang tidak berkaitan*).
- [ ] **Bebas Konflik**: Branch ini sudah up-to-date dengan `main` terbaru dan tidak ada *merge conflicts*.
- [ ] **Bebas Kredensial**: Tidak ada file `.env`, password, token, atau data sensitif yang terkomit.
- [ ] **Standar Kode**: Kode mematuhi standar PSR-12 dan sistem desain Neo-Brutalisme WALHI.
- [ ] **Pengujian Lokal**: Seluruh pengujian lokal telah lulus tanpa error di browser console maupun Laravel logs.
- [ ] **Review**: Siap untuk direview oleh minimal 1 rekan tim / maintainer.
