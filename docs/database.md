# 🗄️ Dokumentasi Basis Data & Skema (Database Guide)

Dokumen ini memetakan arsitektur basis data, skema tabel, indeks, relasi Eloquent, dan casting tipe data pada platform **WALHI Jawa Barat**.

---

## 1. Arsitektur & Driver Basis Data

| Lingkungan | Driver Database | Konfigurasi Default | Catatan |
| :--- | :--- | :--- | :--- |
| **Local / Testing** | `sqlite` | `:memory:` atau `database/database.sqlite` | Eksekusi test suite cepat dan terisolasi. |
| **Production** | `mysql` | MySQL 8.0+ / MariaDB 10.11+ | Charset `utf8mb4`, Collation `utf8mb4_unicode_ci`. |

---

## 2. Skema Tabel Utama

### A. Tabel `contents`
Tabel polimorfik yang menampung seluruh artikel, siaran pers, dokumen resmi, regulasi, profil organisasi, kampanye, dan kontak.

| Kolom | Tipe Data | Nullable | Keterangan |
| :--- | :--- | :---: | :--- |
| `id` | `BIGINT UNSIGNED` | Tidak | Primary Key (Auto Increment). |
| `title` | `VARCHAR(255)` | Tidak | Judul konten. |
| `slug` | `VARCHAR(255)` | Tidak | Unique identifier untuk URL routing. |
| `body` | `LONGTEXT` | Ya | Konten HTML disanitasi via HTMLPurifier. |
| `tags` | `VARCHAR(255)` | Ya | Tags biasa atau metadata terstruktur (`icon\|badge`). |
| `status` | `VARCHAR(50)` | Tidak | Enum `ContentStatus`: `published`, `draft`, `archived` (Default: `draft`). |
| `image_url` | `VARCHAR(255)` | Ya | Path berkas (`documents/uuid.pdf` atau `/storage/uploads/img.jpg`). |
| `publish_date`| `DATE` | Ya | Tanggal rilis konten (`Y-m-d`). |
| `category` | `VARCHAR(50)` | Tidak | Enum `ContentCategory` (21 kategori resmi). |
| `is_promoted` | `BOOLEAN` | Tidak | Sorotan/Headline pada beranda (Default: `false`). |
| `author` | `VARCHAR(255)` | Ya | Nama penulis atau unit kerja WALHI. |
| `views` | `INTEGER UNSIGNED` | Tidak | Metrik jumlah pembaca/unduhan (Default: `0`). |
| `created_at` | `TIMESTAMP` | Ya | Waktu pembuatan. |
| `updated_at` | `TIMESTAMP` | Ya | Waktu pembaruan. |
| `deleted_at` | `TIMESTAMP` | Ya | Soft delete timestamp. |

**Indeks:**
- `UNIQUE(slug)`
- `INDEX(category, status)`
- `INDEX(publish_date)`
- `INDEX(is_promoted)`

---

### B. Tabel `donations`
Mencatat seluruh transaksi donasi yang dilakukan publik.

| Kolom | Tipe Data | Nullable | Keterangan |
| :--- | :--- | :---: | :--- |
| `id` | `BIGINT UNSIGNED` | Tidak | Primary Key. |
| `order_id` | `VARCHAR(255)` | Tidak | Unique Order ID transaksi (misal: `WALHI-DON-1726000000-XYZ`). |
| `donor_name` | `VARCHAR(255)` | Tidak | Nama donatur. |
| `donor_email`| `VARCHAR(255)` | Tidak | Email donatur. |
| `donor_phone`| `VARCHAR(50)` | Ya | Nomor kontak/WhatsApp donatur. |
| `amount` | `BIGINT UNSIGNED` | Tidak | Nominal donasi dalam mata uang Rupiah (IDR). |
| `message` | `TEXT` | Ya | Pesan atau doa dari donatur. |
| `status` | `VARCHAR(50)` | Tidak | Enum `DonationStatus`: `pending`, `success`, `failed`, `expired`. |
| `payment_type`| `VARCHAR(50)` | Ya | Metode bayar Midtrans (`qris`, `bank_transfer`, `gopay`, dll). |
| `campaign_id`| `BIGINT UNSIGNED` | Ya | Foreign key ke `contents.id` (Kategori `donasi`). |
| `created_at` | `TIMESTAMP` | Ya | Waktu transaksi diinisiasi. |
| `updated_at` | `TIMESTAMP` | Ya | Waktu pembaruan status. |
| `deleted_at` | `TIMESTAMP` | Ya | Soft delete timestamp. |

**Indeks:**
- `UNIQUE(order_id)`
- `INDEX(status)`
- `INDEX(campaign_id)`

---

### C. Tabel `comments`
Menyimpan komentar publik pada artikel/konten advokasi.

| Kolom | Tipe Data | Nullable | Keterangan |
| :--- | :--- | :---: | :--- |
| `id` | `BIGINT UNSIGNED` | Tidak | Primary Key. |
| `content_id` | `BIGINT UNSIGNED` | Tidak | Foreign key ke `contents.id` (`onDelete('cascade')`). |
| `parent_id` | `BIGINT UNSIGNED` | Ya | Self-referencing FK untuk balasan komentar 1-level. |
| `author_name`| `VARCHAR(255)` | Tidak | Nama pengirim komentar. |
| `author_email`| `VARCHAR(255)`| Tidak | Email pengirim komentar. |
| `body` | `TEXT` | Tidak | Teks komentar (escaped via Blade `{{ }}`). |
| `status` | `VARCHAR(50)` | Tidak | `pending`, `approved`, `spam` (Default: `pending`). |
| `created_at` | `TIMESTAMP` | Ya | Waktu kirim. |
| `updated_at` | `TIMESTAMP` | Ya | Waktu moderasi. |

**Indeks:**
- `INDEX(content_id, status)`
- `INDEX(parent_id)`

---

### D. Tabel `subscribers`
Daftar email penerima nawala/newsletter berkala.

| Kolom | Tipe Data | Nullable | Keterangan |
| :--- | :--- | :---: | :--- |
| `id` | `BIGINT UNSIGNED` | Tidak | Primary Key. |
| `email` | `VARCHAR(255)` | Tidak | Unique email pelanggan. |
| `created_at` | `TIMESTAMP` | Ya | Waktu berlangganan. |
| `updated_at` | `TIMESTAMP` | Ya | Waktu pembaruan. |
| `deleted_at` | `TIMESTAMP` | Ya | Soft delete timestamp. |

---

### E. Tabel `users`
Akun pengelola administratif dan pengguna terdaftar.

| Kolom | Tipe Data | Nullable | Keterangan |
| :--- | :--- | :---: | :--- |
| `id` | `BIGINT UNSIGNED` | Tidak | Primary Key. |
| `name` | `VARCHAR(255)` | Tidak | Nama lengkap pengguna. |
| `email` | `VARCHAR(255)` | Tidak | Unique email login. |
| `email_verified_at`| `TIMESTAMP` | Ya | Timestamp verifikasi email. |
| `password` | `VARCHAR(255)` | Tidak | Bcrypt hashed password. |
| `role` | `VARCHAR(50)` | Tidak | Enum `UserRole`: `admin`, `editor`, `subscriber` (Default: `subscriber`). |
| `remember_token` | `VARCHAR(100)`| Ya | Remember me token. |
| `created_at` | `TIMESTAMP` | Ya | Waktu pembuatan akun. |
| `updated_at` | `TIMESTAMP` | Ya | Waktu pembaruan. |

---

## 3. Relasi Antar Model (Eloquent Relationships)

```text
  ┌───────────────┐
  │     User      │
  └───────────────┘
          │ (Mengelola / Moderasi via Policy)
          ▼
  ┌───────────────┐
  │    Content    │◄────────┐ 1:N (campaign_id)
  └───────┬───────┘         │
          │ 1:N             │
          ▼                 │
  ┌───────────────┐  ┌───────────────┐
  │    Comment    │  │   Donation    │
  └───────┬───────┘  └───────────────┘
          │ 1:N (parent_id)
          ▼
   (Replies)
```

1. **`Content` ↔ `Comment`**:
   - `$content->comments()`: `hasMany(Comment::class)`.
   - `$comment->content()`: `belongsTo(Content::class)`.
2. **`Comment` ↔ `Comment` (Self-Referencing Replies)**:
   - `$comment->parent()`: `belongsTo(Comment::class, 'parent_id')`.
   - `$comment->replies()`: `hasMany(Comment::class, 'parent_id')`.
3. **`Content` ↔ `Donation`**:
   - `$content->donations()`: `hasMany(Donation::class, 'campaign_id')`.
   - `$donation->campaign()`: `belongsTo(Content::class, 'campaign_id')`.
