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

## 💻 Spesifikasi Server Rekomendasi

- **OS:** Ubuntu 22.04 LTS / 24.04 LTS atau Debian 12
- **CPU:** 2 vCPU core
- **RAM:** 8 GB (Telah di-tuning untuk alokasi MySQL 2.5 GB + PHP-FPM 3.0 GB + OS margin 2.5 GB)
- **Disk:** 100 GB NVMe / SSD
- **Bandwidth:** 8 TB / bulan
- **Software Terpasang:** Docker Engine & Docker Compose v2 (`docker-compose-plugin`)

---

## 🐳 Langkah Deployment Cepat (Turnkey VPS Setup)

### 1. Masuk ke Server VPS Baru Anda
```bash
ssh root@IP_SERVER_VPS_ANDA
```

### 2. Jalankan Skrip Auto-Setup
Skrip ini akan secara otomatis memperbarui sistem, memasang Swap 2 GB (mencegah crash OOM pada 1 vCPU), mengonfigurasi firewall UFW, menginstal Docker Engine resmi, dan menyiapkan cron backup harian:

```bash
curl -fsSL https://raw.githubusercontent.com/Irs622/walhi_larafel/main/setup-vps.sh -o setup-vps.sh
chmod +x setup-vps.sh
sudo ./setup-vps.sh
```

### 3. Clone Repository ke Direktori Produksi
```bash
cd /var/www
git clone https://github.com/Irs622/walhi_larafel.git walhi_app
cd /var/www/walhi_app
```

### 4. Siapkan File `.env` Produksi
Salin template produksi dan sesuaikan nilai-nilainya:
```bash
cp .env.production.example .env
nano .env
```

**Konfigurasi Kunci yang Wajib Diisi:**
- `APP_URL=https://walhijabar.co.id`
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

## 🔒 Konfigurasi Domain & SSL (HTTPS)

### Otomatis Menggunakan Skrip `setup-ssl.sh`:
```bash
cd /var/www/walhi_app
chmod +x setup-ssl.sh
./setup-ssl.sh
```
Skrip ini otomatis:
1. Menginstal certbot.
2. Menerbitkan sertifikat SSL resmi Let's Encrypt untuk `walhijabar.co.id` & `www.walhijabar.co.id`.
3. Mengonfigurasi volume SSL di `docker-compose.prod.yml`.
4. Mengonfigurasi Nginx untuk HTTPS & auto-redirect HTTP ke HTTPS.
5. Memperbarui `APP_URL=https://walhijabar.co.id` dan `SESSION_SECURE_COOKIE=true` di `.env`.
6. Menyetel auto-renewal sertifikat secara berkala via crontab.


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

### Anggaran Memori pada VPS 8 GB RAM:
Container produksi dibatasi secara optimal (*resource limits*) untuk memaksimalkan throughput sekaligus mencegah crash akibat *Out of Memory (OOM)*:
- **`walhi_prod_app` (PHP-FPM 18 workers + Laravel 12)**: Limit **3.072 MB (3 GB)** (Reservasi: 768 MB)
- **`walhi_prod_db` (MySQL 8.0 tuned 1.5 GB buffer pool)**: Limit **2.560 MB (2.5 GB)** (Reservasi: 1.024 MB)
- **`walhi_prod_nginx` (Nginx Alpine Reverse Proxy)**: Limit **512 MB** (Reservasi: 128 MB)
- **Headroom OS, Page Cache & Linux Buffers**: **~2.048 MB (2 GB)** + Swap 4 GB NVMe

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
ab -n 100 -c 10 https://walhijabar.co.id/

# Uji coba 500 request dengan 25 concurrent users:
ab -n 500 -c 25 https://walhijabar.co.id/

# Uji coba 1000 request dengan 50 concurrent users:
ab -n 1000 -c 50 https://walhijabar.co.id/
```
Amati keluaran `docker stats`. Jika penggunaan RAM per PHP-FPM worker stabil dan antrean request rendah, nilai `pm.max_children` di `docker/php/zz-docker.conf` dapat dinaikkan bertahap (8 ➔ 10 ➔ 12) berdasarkan data aktual.
