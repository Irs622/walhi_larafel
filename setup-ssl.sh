#!/usr/bin/env bash
# ─────────────────────────────────────────────────────────────────────────────
# WALHI Jawa Barat — Production SSL (HTTPS) Auto-Configuration Script
# Domain: walhijabar.co.id & www.walhijabar.co.id
# ─────────────────────────────────────────────────────────────────────────────
set -euo pipefail

DOMAIN="walhijabar.co.id"
EMAIL="irsalshydiq@gmail.com"
APP_DIR="/var/www/walhi_app"

echo "==================================================================="
echo "  🔒 WALHI Jawa Barat — Setup SSL HTTPS (Let's Encrypt)"
echo "  Domain: $DOMAIN & www.$DOMAIN"
echo "==================================================================="

# 1. Pastikan dijalankan sebagai root
if [ "$(id -u)" -ne 0 ]; then
    echo "❌ Error: Skrip ini wajib dijalankan sebagai root."
    exit 1
fi

# 2. Install Certbot
echo "📦 [1/6] Memeriksa & menginstal Certbot..."
apt-get update -y
apt-get install -y certbot

# 3. Matikan sementara container web agar port 80 dapat dipakai Certbot
echo "🛑 [2/6] Mematikan sementara Nginx container..."
cd "$APP_DIR"
docker compose -f docker-compose.prod.yml stop web || true

# 4. Menerbitkan sertifikat SSL
echo "📜 [3/6] Menerbitkan sertifikat SSL Let's Encrypt..."
certbot certonly --standalone \
    -d "$DOMAIN" \
    -d "www.$DOMAIN" \
    --non-interactive \
    --agree-tos \
    -m "$EMAIL"

# 5. Pasang volume SSL di docker-compose.prod.yml (jika belum ada)
echo "🐳 [4/6] Mengonfigurasi volume SSL pada docker-compose.prod.yml..."
if ! grep -q '/etc/letsencrypt:/etc/letsencrypt:ro' docker-compose.prod.yml; then
    sed -i '/- .\/docker\/nginx\/default.conf/i \      - /etc/letsencrypt:/etc/letsencrypt:ro' docker-compose.prod.yml
fi

# 6. Konfigurasi Nginx untuk HTTPS
echo "⚙️  [5/6] Mengonfigurasi Nginx untuk HTTPS (Port 443 + HTTP Redirect)..."
cat > "$APP_DIR/docker/nginx/default.conf" <<'NGINX_EOF'
# Redirect all HTTP to HTTPS
server {
    listen 80;
    listen [::]:80;
    server_name walhijabar.co.id www.walhijabar.co.id;

    location /.well-known/acme-challenge/ {
        root /var/www/certbot;
    }

    location / {
        return 301 https://$host$request_uri;
    }
}

# Main HTTPS Server
server {
    listen 443 ssl;
    listen [::]:443 ssl;
    server_name walhijabar.co.id www.walhijabar.co.id;

    ssl_certificate /etc/letsencrypt/live/walhijabar.co.id/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/walhijabar.co.id/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_prefer_server_ciphers on;
    ssl_ciphers 'ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384';
    ssl_session_timeout 1d;
    ssl_session_cache shared:SSL:10m;

    root /var/www/html/public;
    index index.php index.html;

    charset utf-8;
    server_tokens off;
    client_max_body_size 25M;

    # Gzip Compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_proxied expired no-cache no-store private auth;
    gzip_types text/plain text/css text/xml text/javascript application/x-javascript application/xml application/javascript application/json;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;

    # Block direct execution of PHP in storage and assets directories
    location ~* ^/(storage|assets)/.*\.php$ {
        deny all;
        return 404;
    }

    # Block PHP-FPM internal status and ping endpoints
    location ~ ^/(status|ping)$ {
        deny all;
        return 404;
    }

    # Static Assets Caching
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff|woff2|ttf|svg|webp|avif)$ {
        expires 1y;
        add_header Cache-Control "public, no-transform";
        access_log off;
        log_not_found off;
        try_files $uri =404;
    }

    # Storage Symlink Access
    location ^~ /storage/ {
        alias /var/www/html/storage/app/public/;
        expires 30d;
        add_header Cache-Control "public";
        access_log off;
    }

    # Main Application Route
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Prevent Access to Hidden Files (.env, .git, etc.)
    location ~ /\.(?!well-known).* {
        deny all;
    }

    # PHP-FPM FastCGI Handler
    location ~ \.php$ {
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;

        fastcgi_connect_timeout 10s;
        fastcgi_send_timeout 60s;
        fastcgi_read_timeout 60s;

        fastcgi_buffer_size 128k;
        fastcgi_buffers 4 256k;
        fastcgi_busy_buffers_size 256k;

        fastcgi_param HTTPS on;
        fastcgi_param HTTP_SCHEME https;
    }

    error_page 404 /index.php;
}
NGINX_EOF

# 7. Perbarui .env untuk domain HTTPS
echo "📝 [6/6] Menyesuaikan APP_URL dan SESSION_SECURE_COOKIE di .env..."
sed -i 's|^APP_URL=.*|APP_URL=https://walhijabar.co.id|g' "$APP_DIR/.env"
sed -i 's|^SESSION_SECURE_COOKIE=.*|SESSION_SECURE_COOKIE=true|g' "$APP_DIR/.env"

# Jalankan ulang stack docker
echo "🚀 Menjalankan ulang container web & app..."
docker compose -f docker-compose.prod.yml up -d
docker compose -f docker-compose.prod.yml exec app php artisan optimize:clear
docker compose -f docker-compose.prod.yml exec app php artisan config:cache
docker compose -f docker-compose.prod.yml exec app php artisan route:cache
docker compose -f docker-compose.prod.yml exec app php artisan view:cache

# Setup auto renewal cron jika belum ada
CRON_RENEW="0 3 * * 1 certbot renew --quiet --deploy-hook \"docker compose -f /var/www/walhi_app/docker-compose.prod.yml restart web\""
(crontab -l 2>/dev/null | grep -Fv 'certbot renew' ; echo "$CRON_RENEW") | crontab -

echo ""
echo "==================================================================="
echo "  🎉 SUKSES! SSL HTTPS BERHASIL DIAKTIFKAN!"
echo "  Silakan buka: https://walhijabar.co.id"
echo "==================================================================="
