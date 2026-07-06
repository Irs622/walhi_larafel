Berikut adalah tutorial langkah demi langkah untuk menjalankan project Laravel ini di komputer Anda:

Langkah 1: Buka Terminal
Buka aplikasi Terminal di Mac Anda.

Langkah 2: Masuk ke Folder Project
Salin dan jalankan perintah berikut di Terminal untuk masuk ke direktori project Anda:

bash
cd "/Users/mac/clone walhi/walhi_larafel"
Langkah 3: Jalankan Project (Cara Paling Mudah)
Project ini sudah dikonfigurasi untuk menjalankan Web Server Laravel (php artisan serve), Queue Listener, Log Viewer, dan Asset Compiler (vite) secara bersamaan menggunakan satu perintah:

bash
composer run dev
Langkah 4: Akses Aplikasi di Browser
Setelah perintah di atas berjalan, buka browser Anda (Chrome, Safari, dll.) dan buka alamat berikut: 👉 http://127.0.0.1:8000

Opsi Alternatif: Menjalankan Secara Terpisah
Jika Anda lebih suka menjalankan server PHP dan Vite (Tailwind CSS/JS) di jendela/tab terminal yang berbeda agar log-nya terpisah:

Tab Terminal 1 (Web Server PHP):
bash
php artisan serve
Tab Terminal 2 (Asset Compiler / Vite):
bash
npm run dev
(Jika database belum ada atau ingin di-migrasi ulang sewaktu-waktu, Anda juga bisa menjalankan php artisan migrate --seed terlebih dahulu)
