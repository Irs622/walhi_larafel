# 🚀 Panduan Menjalankan WALHI Jawa Barat

Project ini dapat dijalankan secara otomatis menggunakan **Docker Container** (tanpa perlu install PHP, Node.js, atau setup manual di komputer Anda) atau secara manual menggunakan PHP & Composer.

---

## 🐳 Cara 1: Menjalankan Menggunakan Docker (Paling Praktis & Otomatis)

Cukup **1 perintah**, seluruh environment (PHP 8.3, Database SQLite/MySQL, Assets Build, Migrasi, & Seeder) akan berjalan otomatis di dalam container Docker!

### Langkah-langkah:

1. **Buka Terminal & Masuk ke Folder Project:**
   ```bash
   cd /Users/mac/Downloads/walhi/walhi_larafel
   ```

2. **Jalankan Docker Container:**
   ```bash
   docker compose up -d --build
   ```

3. **Akses Aplikasi di Browser:**
   👉 Buka [http://localhost:8000](http://localhost:8000)

* **Untuk Menghentikan Container:**
  ```bash
  docker compose down
  ```
* **Untuk Melihat Log Aplikasi:**
  ```bash
  docker compose logs -f
  ```

---

## 💻 Cara 2: Menjalankan Secara Manual (Tanpa Docker)

### Langkah-langkah:

1. **Masuk ke Folder Project:**
   ```bash
   cd /Users/mac/Downloads/walhi/walhi_larafel
   ```

2. **Jalankan Semua Service Otomatis:**
   ```bash
   composer run dev
   ```
   *(Perintah ini akan menjalankan Web Server PHP, Queue, Log Viewer, dan Vite Asset Compiler secara otomatis).*

3. **Akses Aplikasi di Browser:**
   👉 Buka [http://127.0.0.1:8000](http://127.0.0.1:8000)
