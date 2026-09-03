# 🚀 Panduan Deployment & Operasional Produksi (Production Deployment Guide)

Dokumen ini berisi panduan langkah-demi-langkah untuk mendeploy dan mengoperasikan aplikasi web **WALHI Jawa Barat** di server produksi (VPS Ubuntu / Debian / Cloud Server).

---

## 📋 Daftar Isi
1. [Spesifikasi Server Minimum](#-spesifikasi-server-minimum)
2. [Langkah Deployment Produksi (Docker Compose)](#-langkah-deployment-produksi-docker-compose)
3. [Konfigurasi Domain & SSL (HTTPS)](#-konfigurasi-domain--ssl-https)
4. [Backup & Restore Database Otomatis](#-backup--restore-database-otomatis)
5. [Monitoring & Manajemen Log](#-monitoring--manajemen-log)
6. [Prosedur Pembaruan Aplikasi (CI/CD Deployment)](#-prosedur-pembaruan-aplikasi)

---

## 💻 Spesifikasi Server Minimum

- **OS:** Ubuntu 22.04 LTS / 24.04 LTS atau Debian 12
- **CPU:** 2 vCPU
- **RAM:** 2 GB (Rekomendasi: 4 GB)
- **Disk:** 25 GB SSD (Untuk OS, Docker images, MySQL database, dan PDF laporan)
- **Software Terpasang:** Docker Engine & Docker Compose v2 (`docker-compose-plugin`)

---

## 🐳 Langkah Deployment Produksi (Docker Compose)

### 1. Masuk ke Server VPS
```bash
ssh user@ip-server-walhi
```

### 2. Install Docker & Docker Compose (Jika belum ada)
```bash
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo usermod -aG docker $USER
```

### 3. Clone Repository ke Server
```bash
cd /var/www
git clone https://github.com/Irs622/walhi_larafel.git walhi_app
cd walhi_app
```

### 4. Siapkan File `.env` Produksi
Salin template produksi dan sesuaikan nilai-nilainya:
```bash
cp .env.production.example .env
nano .env
```

**Konfigurasi Kunci yang Wajib Diisi:**
- `APP_URL=https://walhijabar.or.id`
- `DB_PASSWORD` & `DB_ROOT_PASSWORD` (Gunakan password acak kuat minimal 24 karakter — **DILARANG** menggunakan string default contoh)
- `MIDTRANS_SERVER_KEY` & `MIDTRANS_CLIENT_KEY` (Kunci produksi akun Midtrans resmi)
- `ADMIN_PASSWORD` (Password akun Super Admin)

> [!IMPORTANT]
> **Checklist Keamanan Kredensial Database:**
> 1. Pastikan password database `DB_PASSWORD` dan `DB_ROOT_PASSWORD` bukan string contoh historis (`walhi_secret_pass` / `walhi_root_secret`).
> 2. Generate password baru dengan entropi tinggi: `openssl rand -base64 24`.
> 3. Jika melakukan rotasi password pada database MySQL yang sedang berjalan:
>    ```bash
>    docker exec -it walhi_prod_db mysql -u root -p -e "ALTER USER 'walhi_user'@'%' IDENTIFIED BY 'PASSWORD_BARU_ANDA'; FLUSH PRIVILEGES;"
>    ```
>    Lalu perbarui variabel `DB_PASSWORD` di `.env` dan restart container aplikasi (`docker compose -f docker-compose.prod.yml restart app`).

### 5. Jalankan Stack Produksi
```bash
docker compose -f docker-compose.prod.yml up -d --build
```

Setelah perintah selesai, 3 container akan otomatis berjalan:
- `walhi_prod_app` (Aplikasi Laravel 12 / PHP 8.4)
- `walhi_prod_db` (Basis data MySQL 8.0)
- `walhi_prod_nginx` (Web Server Nginx & Reverse Proxy)

---

## 🔒 Konfigurasi Domain & SSL (HTTPS)

Untuk mengamankan website dengan sertifikat SSL gratis via Let's Encrypt / Certbot:

### Menggunakan Certbot di Host Server:
```bash
sudo apt update && sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d walhijabar.or.id -d www.walhijabar.or.id
```

### Atau via Cloudflare SSL (Paling Praktis):
1. Arahkan DNS domain `walhijabar.or.id` (A Record) ke IP Server VPS Anda.
2. Aktifkan **Proxy Cloudflare (Orange Cloud ☁️)**.
3. Set mode SSL/TLS di dashboard Cloudflare ke **Full (Strict)**.

---

## 💾 Backup & Restore Database Otomatis

### Menjalankan Backup Manual:
```bash
./docker-backup.sh
```
File backup terkompresi (`.sql.gz`) akan tersimpan di folder `storage/backups/`.

### Mengatur Backup Otomatis Harian (Cron Job):
Buka crontab server:
```bash
crontab -e
```
Tambahkan baris berikut untuk backup otomatis setiap jam 02.00 dini hari:
```cron
0 2 * * * cd /var/www/walhi_app && ./docker-backup.sh >> /var/log/walhi_backup.log 2>&1
```

### Melakukan Restore Database dari File Backup:
```bash
gunzip < storage/backups/walhi_prod_mysql_YYYYMMDD_HHMMSS.sql.gz | docker exec -i walhi_prod_db mysql -u <DB_USERNAME> -p<DB_PASSWORD> <DB_DATABASE>
```

---

## 📊 Monitoring, Alokasi RAM & Benchmark

### Anggaran Memori pada VPS 4 GB RAM:
Container produksi dibatasi secara ketat (*hard memory limit*) untuk mencegah crash akibat *Out of Memory (OOM)*:
- **`walhi_prod_app` (PHP-FPM 8 workers + Laravel 12)**: Limit **1.536 MB** (Reservasi: 512 MB)
- **`walhi_prod_db` (MySQL 8.0 tuned buffer pool)**: Limit **1.280 MB** (Reservasi: 512 MB)
- **`walhi_prod_nginx` (Nginx Alpine Reverse Proxy)**: Limit **256 MB** (Reservasi: 64 MB)
- **Headroom OS, Page Cache & Docker Daemon**: **~1.024 MB (1 GB)**

### Memeriksa Penggunaan CPU & RAM Realtime:
```bash
docker stats
```
> **Target Normal:** Total konsumsi RAM server berada di kisaran 50% – 70%. Jika beban puncak (*peak*) mencapai 75% – 85%, server masih memiliki toleransi aman tanpa risiko *kernel panic*.

### Melihat Log Realtime:
```bash
# Log seluruh stack produksi
docker compose -f docker-compose.prod.yml logs -f

# Log Laravel application saja
docker compose -f docker-compose.prod.yml logs -f app
```

---

## 🔄 Prosedur Pembaruan Aplikasi (Update Workflow)

Saat ada pembaruan kode di branch `main` GitHub yang ingin di-deploy ke server live:

```bash
# 1. Masuk ke direktori aplikasi
cd /var/www/walhi_app

# 2. Ambil pembaruan kode terbaru
git pull origin main

# 3. Build ulang image container dan jalankan stack produksi
docker compose -f docker-compose.prod.yml up -d --build

# 4. Jalankan migrasi database secara eksplisit (Explicit Release Step)
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force
```

Alur ini memastikan:
1. Kode dan aset frontend ter-compile ulang secara deterministik (`npm ci`).
2. PHP-FPM dan OPcache termuat ulang secara bersih (*fresh bytecodes*).
3. Skema database termigrasi secara terkontrol tanpa mengganggu restart rutin container.
4. Cache produksi teroptimasi penuh (`config:cache`, `route:cache`, `view:cache`).

---

## 🧪 Panduan Load Testing Staging / Production

Sebelum promosi traffic masif, lakukan pengujian konkurensi bertahap dari workstation pengembang atau server staging:

```bash
# Menggunakan ApacheBench (ab) atau k6 / wrk
# Uji coba 100 request dengan 10 concurrent users:
ab -n 100 -c 10 https://walhijabar.or.id/

# Uji coba 500 request dengan 25 concurrent users:
ab -n 500 -c 25 https://walhijabar.or.id/

# Uji coba 1000 request dengan 50 concurrent users:
ab -n 1000 -c 50 https://walhijabar.or.id/
```
Amati keluaran `docker stats`. Jika penggunaan RAM per PHP-FPM worker stabil dan antrean request rendah, nilai `pm.max_children` di `docker/php/zz-docker.conf` dapat dinaikkan bertahap (8 ➔ 10 ➔ 12) berdasarkan data aktual.
