# Rekapitulasi Isu Audit Keamanan & Arsitektur WALHI Jawa Barat

Dokumen ini berisi rangkuman issue hasil audit keamanan, arsitektur, dan kualitas kode menyeluruh untuk aplikasi web WALHI Jawa Barat.

---

## 📊 Matriks Skala Prioritas Isu

| ID | Prioritas | Judul Isu | Berkas Terkait | Labels | Berkas Detail |
| :---: | :---: | :--- | :--- | :--- | :--- |
| **#1** | 🔴 **P0** | [SECURITY] Ganti Single-Threaded 'php artisan serve' dengan PHP-FPM pada Dockerfile Produksi | `Dockerfile`, `docker-compose.prod.yml`, `docker/nginx/default.conf` | `priority-p0`, `security`, `hardening`, `backend` | [ISSUE-01](./issues/ISSUE-01-P0-docker-php-fpm-single-threaded-serve.md) |
| **#2** | 🟠 **P1** | [SECURITY] Hardening Dockerfile: Jalankan Container dengan Non-Root User (Least Privilege) | `Dockerfile` | `priority-p1`, `security`, `hardening` | [ISSUE-02](./issues/ISSUE-02-P1-dockerfile-non-root-user-hardening.md) |
| **#3** | 🟡 **P2** | [PERF] Optimasi Kueri N+1 Agregasi Bulanan pada ContentController::buildMonthlyChart | `app/Http/Controllers/Admin/ContentController.php` | `priority-p2`, `backend`, `enhancement` | [ISSUE-03](./issues/ISSUE-03-P2-n-plus-1-query-donation-chart.md) |
| **#4** | 🟡 **P2** | [SECURITY] Perluas Filter Karakter CSV Formula Injection pada Fitur Ekspor Newsletter | `app/Http/Controllers/Admin/AdminSubscriberController.php` | `priority-p2`, `security`, `backend`, `hardening` | [ISSUE-04](./issues/ISSUE-04-P2-csv-formula-injection-sanitization.md) |
| **#5** | 🔵 **P3** | [BUG] Ganti Pemanggilan env() Langsung pada AdminUserSeeder dengan Helper config() | `database/seeders/AdminUserSeeder.php`, `config/auth.php` | `priority-p3`, `bug`, `backend` | [ISSUE-05](./issues/ISSUE-05-P3-admin-user-seeder-config-cache.md) |
| **#6** | 🔵 **P3** | [SECURITY] Terapkan Fail-Safe Defaults untuk APP_DEBUG & SESSION_SECURE_COOKIE di docker-entrypoint.sh | `docker-entrypoint.sh` | `priority-p3`, `security`, `hardening` | [ISSUE-06](./issues/ISSUE-06-P3-docker-entrypoint-fail-safe-defaults.md) |
| **#7** | 🔵 **P3** | [DATABASE] Tambahkan Migration Indeks Komposit pada Tabel Comments untuk Optimasi Threading | `database/migrations/` | `priority-p3`, `backend`, `enhancement` | [ISSUE-07](./issues/ISSUE-07-P3-composite-index-comments-table.md) |
| **#8** | ⚪ **P3** | [DOCS] Bersihkan Tautan Absolut Workstation Lokal Pengembang pada Dokumen SECURITY.md | `SECURITY.md` | `priority-p3`, `documentation` | [ISSUE-08](./issues/ISSUE-08-P3-cleanup-local-workstation-paths-docs.md) |

---
*Generated as part of Comprehensive Laravel Security, Architecture & Quality Code Audit.*
