📖 Tutorial Manual Menjalankan Projek
Langkah 1: Buka Terminal
Buka aplikasi Terminal di Mac Anda.

Langkah 2: Masuk ke Direktori Projek
Salin dan jalankan perintah berikut untuk masuk ke folder projek Laravel Anda:

bash
cd "/Users/mac/clone walhi/walhi_larafel"
Langkah 3: Pastikan Database SQLite Siap
Projek Anda dikonfigurasi menggunakan SQLite (database/database.sqlite). Untuk memastikan database siap dan berisi data awal, jalankan perintah ini:

bash
# Membuat file database jika belum ada
touch database/database.sqlite
# Menjalankan migrasi database serta mengisi data awal (seeding)
php artisan migrate --seed
Langkah 4: Jalankan Projek
Anda dapat menjalankan projek menggunakan salah satu opsi di bawah ini:

Opsi A: Menggunakan Composer Script Bawaan (Paling Mudah)
Projek ini sudah dikonfigurasi untuk menjalankan server PHP, Vite, Queue, dan Logger sekaligus dalam satu perintah:

bash
composer run dev
Opsi B: Menjalankan Secara Terpisah
Jika ingin memantau log web server dan asset builder secara terpisah, buka dua tab terminal dan jalankan:

Terminal Tab 1 (Web Server Laravel):

bash
php artisan serve
(Server akan berjalan di http://127.0.0.1:8000)

Terminal Tab 2 (Vite Asset Server untuk Tailwind CSS & JS):

bash
npm run dev
Setelah menjalankan perintah di atas, Anda bisa langsung membuka browser Anda dan mengakses alamat http://127.0.0.1:8000.
