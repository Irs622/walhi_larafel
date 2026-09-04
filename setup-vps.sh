#!/usr/bin/env bash
# ─────────────────────────────────────────────────────────────────────────────
# WALHI Jawa Barat — Production VPS Auto-Provisioning Script
# Target: Ubuntu 22.04 / 24.04 LTS or Debian 12 (1 vCPU / 4 GB RAM / 50 GB NVMe)
# ─────────────────────────────────────────────────────────────────────────────
set -euo pipefail

echo "==================================================================="
echo "  🌿 WALHI Jawa Barat — Production VPS Setup"
echo "  Target: 1 vCPU / 4 GB RAM / 50 GB NVMe"
echo "==================================================================="

# 1. Ensure script is run as root
if [ "$(id -u)" -ne 0 ]; then
    echo "❌ Error: Skrip ini wajib dijalankan dengan hak akses root (gunakan sudo)."
    exit 1
fi

# 2. System updates
echo "📦 [1/6] Memperbarui repositori paket Ubuntu/Debian..."
apt-get update -y
DEBIAN_FRONTEND=noninteractive apt-get upgrade -y
DEBIAN_FRONTEND=noninteractive apt-get install -y curl git ufw htop ca-certificates gnupg lsb-release

# 3. Setup 2 GB Swap file (Krusial untuk 1 vCPU / 4 GB RAM agar OOM-safe)
echo "💾 [2/6] Memeriksa dan mengonfigurasi 2 GB Swap File..."
if [ ! -f /swapfile ]; then
    fallocate -l 2G /swapfile || dd if=/dev/zero of=/swapfile bs=1M count=2048
    chmod 600 /swapfile
    mkswap /swapfile
    swapon /swapfile
    if ! grep -q '/swapfile' /etc/fstab; then
        echo '/swapfile none swap sw 0 0' >> /etc/fstab
    fi
    echo "✅ Swap 2 GB berhasil dibuat dan diaktifkan."
else
    echo "ℹ️  Swap file sudah ada, melewati pembuatan swap."
fi

# Optimasi swappiness (prioritaskan RAM, swap hanya untuk darurat)
sysctl -w vm.swappiness=10
sysctl -w vm.vfs_cache_pressure=50
if ! grep -q 'vm.swappiness=10' /etc/sysctl.conf; then
    echo "vm.swappiness=10" >> /etc/sysctl.conf
    echo "vm.vfs_cache_pressure=50" >> /etc/sysctl.conf
fi

# 4. Install Docker Engine & Docker Compose Plugin (Official)
echo "🐳 [3/6] Memeriksa instalasi Docker Engine..."
if ! command -v docker &> /dev/null; then
    echo "       Mengunduh dan menginstal Docker resmi..."
    curl -fsSL https://get.docker.com -o /tmp/get-docker.sh
    sh /tmp/get-docker.sh
    rm -f /tmp/get-docker.sh
    systemctl enable docker
    systemctl start docker
    echo "✅ Docker Engine berhasil diinstal."
else
    echo "ℹ️  Docker sudah terinstal ($(docker --version))."
fi

# 5. Konfigurasi Firewall (UFW)
echo "🛡️  [4/6] Mengonfigurasi firewall UFW..."
ufw default deny incoming
ufw default allow outgoing
ufw allow 22/tcp comment 'SSH Port'
ufw allow 80/tcp comment 'HTTP Web'
ufw allow 443/tcp comment 'HTTPS Web'
ufw --force enable
echo "✅ Firewall aktif (Port 22, 80, 443 terbuka)."

# 6. Direktori Kerja Produksi
echo "📁 [5/6] Menyiapkan direktori produksi /var/www..."
mkdir -p /var/www
mkdir -p /var/backups/walhi_db

# 7. Backup Otomatis Harian via Cron
echo "⏰ [6/6] Menyiapkan cron job backup database otomatis harian..."
BACKUP_SCRIPT="/usr/local/bin/walhi-backup.sh"
cat > "$BACKUP_SCRIPT" <<'EOF'
#!/usr/bin/env bash
BACKUP_DIR="/var/backups/walhi_db"
mkdir -p "$BACKUP_DIR"
TIMESTAMP=$(date +'%Y%m%d_%H%M%S')
TARGET_FILE="$BACKUP_DIR/walhi_db_$TIMESTAMP.sql.gz"

if docker ps | grep -q walhi_prod_db; then
    docker exec walhi_prod_db sh -c 'exec mysqldump -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE"' | gzip > "$TARGET_FILE"
    chmod 600 "$TARGET_FILE"
    # Hapus backup yang lebih tua dari 14 hari
    find "$BACKUP_DIR" -type f -name "*.sql.gz" -mtime +14 -delete
fi
EOF
chmod +x "$BACKUP_SCRIPT"

# Pasang cron jika belum ada
CRON_JOB="0 2 * * * /usr/local/bin/walhi-backup.sh >/dev/null 2>&1"
(crontab -l 2>/dev/null | grep -Fv "$BACKUP_SCRIPT" ; echo "$CRON_JOB") | crontab -

echo ""
echo "==================================================================="
echo "  🎉 SETUP VPS SELESAI! Server Anda sudah 100% siap untuk deploy."
echo "==================================================================="
echo ""
echo "Langkah selanjutnya untuk menjalankan website WALHI:"
echo ""
echo "1. Clone repository ke /var/www/walhi_app (jika belum):"
echo "   cd /var/www"
echo "   git clone https://github.com/Irs622/walhi_larafel.git walhi_app"
echo "   cd /var/www/walhi_app"
echo ""
echo "2. Buat file .env produksi:"
echo "   cp .env.production.example .env"
echo "   nano .env"
echo "   (Setel DB_PASSWORD, APP_KEY, ADMIN_PASSWORD, APP_URL)"
echo ""
echo "3. Jalankan aplikasi:"
echo "   docker compose -f docker-compose.prod.yml up -d --build"
echo ""
echo "4. Jalankan migrasi database:"
echo "   docker compose -f docker-compose.prod.yml exec app php artisan migrate --force"
echo "==================================================================="
