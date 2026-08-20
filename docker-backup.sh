#!/bin/bash
# ─────────────────────────────────────────────────────────────
# WALHI Jawa Barat — Automated Database Backup Script
# ─────────────────────────────────────────────────────────────
set -e

BACKUP_DIR="${BACKUP_DIR:-./storage/backups}"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
mkdir -p "$BACKUP_DIR"

echo "📦 Starting WALHI database backup: $TIMESTAMP"

# Load environment variables from .env if present
if [ -f .env ]; then
    export $(grep -E '^(DB_USERNAME|DB_PASSWORD|DB_DATABASE)=' .env | xargs) 2>/dev/null || true
fi

# 1. Check if production MySQL container is running
if docker ps --format '{{.Names}}' | grep -q "^walhi_prod_db$"; then
    echo "💾 Backing up MySQL database from walhi_prod_db..."
    BACKUP_FILE="$BACKUP_DIR/walhi_prod_mysql_$TIMESTAMP.sql.gz"
    
    MYSQL_USER="${DB_USERNAME:-walhi_user}"
    MYSQL_DB="${DB_DATABASE:-walhi_prod}"
    
    if [ -n "$DB_PASSWORD" ]; then
        docker exec walhi_prod_db mysqldump -u "$MYSQL_USER" -p"$DB_PASSWORD" "$MYSQL_DB" | gzip > "$BACKUP_FILE"
    else
        docker exec walhi_prod_db mysqldump -u "$MYSQL_USER" "$MYSQL_DB" | gzip > "$BACKUP_FILE"
    fi
    echo "✅ MySQL backup saved: $BACKUP_FILE ($(du -h "$BACKUP_FILE" | cut -f1))"

# 2. Check if SQLite database exists
elif [ -f "./storage/app/database.sqlite" ]; then
    echo "💾 Backing up SQLite database..."
    BACKUP_FILE="$BACKUP_DIR/walhi_sqlite_$TIMESTAMP.sqlite.gz"
    gzip -c "./storage/app/database.sqlite" > "$BACKUP_FILE"
    echo "✅ SQLite backup saved: $BACKUP_FILE ($(du -h "$BACKUP_FILE" | cut -f1))"

else
    echo "⚠️ No running database container or SQLite file found to back up."
    exit 1
fi

# 3. Clean up backups older than 30 days
find "$BACKUP_DIR" -type f -name "walhi_*" -mtime +30 -exec rm {} \;
echo "🧹 Old backups (>30 days) cleaned up."
echo "🎉 Backup completed successfully!"
