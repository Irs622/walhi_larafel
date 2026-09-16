# 📜 Panduan Aturan Domain & Invariant Bisnis (Domain Rules)

Dokumen ini mendokumentasikan aturan bisnis, siklus hidup entitas, dan batasan operasional pada platform **WALHI Jawa Barat**. Aturan ini wajib dipatuhi oleh seluruh developer dan AI coding agents untuk menjaga konsistensi data dan integritas keamanan.

---

## 1. Domain Konten & Publikasi (`Content`)

Tabel `contents` adalah entitas pusat yang menampung seluruh artikel, siaran pers, dokumen resmi, profil organisasi, hingga kampanye.

### A. Siklus Hidup Status (`ContentStatus`)
```text
[Draf (draft)] ───(Publish)───► [Dipublikasikan (published)] ───(Arsipkan)───► [Diarsipkan (archived)]
      │                                       │                                       │
      └───────────────────────────────────────┴───────────────────────────────────────┘
                                              │
                                     (Toggle Status Action)
```

1. **Status yang Diizinkan:**
   - `published`: Konten aktif dan dapat diakses oleh publik secara bebas.
   - `draft`: Konten belum selesai atau menunggu peninjauan editorial.
   - `archived`: Konten historis yang dinonaktifkan dari listing publik.
2. **Aturan Akses Publik:**
   - Halaman publik (`/blog`, `/konten/{slug}`, `/regulasi`, `/publikasi/*`) **hanya** menampilkan konten berstatus `published`.
   - Permintaan publik/tamu untuk melihat konten `draft` atau `archived` via `/konten/{slug}` atau endpoint unduhan **wajib menghasilkan HTTP `404 Not Found`** untuk mencegah *resource enumeration*.
   - Pengguna dengan hak kelola (`canManageContent()`) dapat melihat pratinjau konten non-publik saat terautentikasi.

### B. Kategori Konten (`ContentCategory`)
Seluruh konten terikat pada 21 nilai Enum resmi (`App\Enums\ContentCategory`):

| Kelompok | Kategori Enum (`value`) | Karakteristik / Penanganan Khusus |
| :--- | :--- | :--- |
| **Publikasi Berita** | `blog`, `siaran-pers`, `infografis`, `kertas-posisi`, `catatan-kritis` | Mendukung lampiran PDF, gambar cover, tag, dan komentar publik. |
| **Dokumen Resmi** | `regulasi`, `laporan-tahunan` | Berkas PDF disimpan ke **private storage**. |
| **Terbitan Berkala** | `newsletter`, `buletin-bumi`, `jurnal` | Publikasi periodik organisasi. |
| **Profil Organisasi**| `sejarah`, `visi-misi`, `dewan-nasional`, `eksekutif-nasional`, `eksekutif-daerah`, `kontak` | Kategori `kontak` adalah **kategori sensitif** (khusus Admin). Cache view dibersihkan otomatis saat diupdate. |
| **Kampanye & Event** | `donasi`, `pekan-rakyat`, `kampanye-darurat` | Kategori `donasi` dan `kampanye-darurat` adalah **kategori sensitif** (khusus Admin). Cache view dibersihkan otomatis. |
| **Beranda** | `banner`, `statistik`, `isu-kritis` | Hero banner slider interaktif, angka capaian, dan isu strategis. |

### C. Format Khusus Kolom `tags`
Beberapa kategori meng-encode metadata struktural ke dalam kolom `tags`:
1. **Kategori `banner`:**
   - Format: `{btn1_text}|{btn1_url}|{btn2_text}|{btn2_url}`
   - Contoh: `Isu Strategis|#isu|Lihat Publikasi|/publikasi/siaran-pers`
2. **Kategori `isu-kritis`:**
   - Format: `{nama_icon}|{badge_text}`
   - Contoh: `Icon-4.svg|Isu Air & Pesisir`
   - Default jika kosong: `Icon-4.svg|Isu`
3. **Kategori `regulasi`:**
   - Format: `{kategori_regulasi}, {penerbit}, {status}`
   - Contoh: `undang-undang, Pemerintah RI, berlaku`
4. **Kategori lainnya:**
   - String tag teks biasa dipisahkan koma (contoh: `advokasi, cirebon, pltu`).

### D. Sanitasi Konten HTML (Rich Text)
- Input `body` dari editor Quill disanitasi menggunakan `HTMLPurifier` melalui accessor `Content::getSanitizedBodyAttribute()`.
- Scheme yang diizinkan dalam tag `<a>` dan `<img>`: `http`, `https`, `mailto`, `tel`.
- Rendering pada view Blade:
  - **✅ BENAR:** `{!! $item->sanitized_body !!}`
  - **❌ SALAH:** `{!! $item->body !!}` (membuka celah XSS).

---

## 2. Domain Penyimpanan Berkas & Dokumen (SEC-008)

Platform memisahkan media publik dan dokumen organisasi secara tegas guna mencegah kebocoran dokumen non-publik:

```text
Berkas Unggahan Masuk
       │
       ├─► Bertipe Dokumen (PDF, DOC, DOCX, XLS, XLSX)
       │         ↓
       │   Storage::disk('local') ──► storage/app/private/documents/
       │         ↓
       │   Dilayani via Endpoint Terotorisasi: GET /dokumen/{slug}/unduh
       │         ↓
       │   Headers: nosniff, Content-Disposition: attachment
       │
       └─► Bertipe Media Gambar (JPG, PNG, WebP, GIF)
                 ↓
           Storage::disk('public') ──► storage/app/public/uploads/
                 ↓
           Dilayani via Web Server Statis: /storage/uploads/...
```

### Invariant & Aturan Operasional Storage:
1. **Penyimpanan Dokumen Baru:**
   - Berkas dokumen (`pdf`, `doc`, `docx`, `xls`, `xlsx`) disimpan pada disk `'local'` (`storage/app/private/documents/`).
   - Berkas ini **tidak dapat diakses langsung** melalui URL statis web server `/storage/...`.
2. **Otorisasi Unduhan Dokumen:**
   - Route unduhan: `GET /dokumen/{content:slug}/unduh` via `DocumentDownloadController`.
   - Otorisasi dikontrol oleh `ContentPolicy@view`:
     - Konten `published`: Dapat diunduh tamu publik.
     - Konten `draft`/`archived`: Tamu mendapat `404`; user tanpa izin mendapat `403`.
3. **Tanpa Open-Redirect:**
   - Dokumen bertautan eksternal (`http://`, `https://`) **tidak boleh** dilayani via redirector controller. Tautan keluar dirender langsung di view melalui `$item->download_url`.
4. **Pencegahan Header Injection:**
   - Nama file unduhan dibersihkan dari karakter CRLF (`\r`, `\n`) dan tanda kutip. Ekstensi file ditentukan dari berkas fisik di server (`pathinfo`).
5. **Alat Migrasi Dokumen Legacy:**
   - Gunakan `php artisan walhi:migrate-documents {--delete-legacy}` untuk memindahkan file dokumen publik lama ke disk privat dan menormalkan path database.

---

## 3. Domain Donasi & Pembayaran Online (`Donation`)

Modul donasi memfasilitasi penggalangan dana publik dengan integrasi gateway pembayaran Midtrans Snap.

### A. State Machine Status Donasi (`DonationStatus`)
```text
           ┌───────────────► [Berhasil (success)] (Terminal)
           │
[Menunggu (pending)] ──────► [Gagal (failed)]     (Terminal)
           │
           └───────────────► [Kadaluarsa (expired)](Terminal)
```

1. **Integritas Transisi Status:**
   - `pending` dapat berpindah ke `success`, `failed`, atau `expired`.
   - `success` adalah **status terminal absolut**. Status yang sudah `success` **tidak dapat diubah** menjadi status lain (misal oleh webhook terlambat/out-of-order).
   - Replay webhook dengan status yang sama diperlakukan secara idempoten (sukses tanpa mutasi ulang).
2. **Konkurensi & Locking:**
   - Pemrosesan webhook di `DonationService::processWebhook()` wajib dieksekusi dalam transaksi basis data atomik (`DB::transaction`) menggunakan row-level pessimistic lock (`lockForUpdate()`).
3. **Verifikasi Webhook Midtrans:**
   - Di lingkungan produksi, IP pengirim divalidasi terhadap subnet resmi Midtrans (`config('midtrans.ip_whitelist')`).
   - Tanda tangan kriptografis SHA-512 diverifikasi:
     ```php
     hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey)
     ```
   - Nominal `gross_amount` payload wajib sama persis dengan nominal `amount` pada database.
4. **Simulasi Pembayaran (Mock Payment):**
   - Route `/donasi/mock-payment-status` **hanya terdaftar dan aktif** pada lingkungan `local` dan `testing`. Route ini dilarang keras diaktifkan di `production`.

---

## 4. Domain Pengguna & Otorisasi Hak Akses (RBAC)

Aplikasi menerapkan 3 peran pengguna (`App\Enums\UserRole`):

| Peran (`UserRole`) | Hak Akses Konten Standar | Hak Akses Kategori Sensitif | Hak Aksi Destruktif (Hapus) |
| :--- | :---: | :---: | :---: |
| **`admin`** | Buat, Ubah, Terbitkan | **Ya** (`kontak`, `donasi`, `kampanye-darurat`) | **Ya** (Konten, Komentar, Subscriber) |
| **`editor`** | Buat, Ubah, Terbitkan | **Tidak** (Ditolak `403 Forbidden`) | **Tidak** (Ditolak `403 Forbidden`) |
| **`subscriber`** | Hanya Baca Publik | **Tidak** | **Tidak** |

### Boundary Routing Kategori:
- Parameter `{category}` pada routing `/admin/{category}` dibatasi oleh regex daftar nilai Enum `ContentCategory::cases()`.
- Request dengan kategori di luar daftar akan ditolak langsung pada level routing HTTP dengan respon **`404 Not Found`** sebelum controller dipanggil.

---

## 5. Domain Komentar Artikel (`Comment`)

1. **Moderasi Komentar:**
   - Komentar baru berstatus default `pending`.
   - Hanya komentar berstatus `approved` yang ditampilkan pada detail artikel publik.
2. **Proteksi Spam (Honeypot):**
   - Form komentar memuat field tersembunyi `website_hp`. Jika field ini terisi oleh bot, submission diabaikan secara diam-diam (*silent drop*) tanpa memberi tahu bot.
3. **Struktur Balasan (Hierarchy):**
   - Maksimal kedalaman balasan adalah 1 level (`parent_id`). Balasan wajib memiliki `parent_id` yang sah dan menginduk pada artikel yang sama.

---

## 6. Domain Newsletter (`Subscriber`)

1. **Registrasi Email:**
   - Validasi email unik berbasis RFC.
2. **Ekspor CSV Aman (Anti Formula Injection):**
   - Saat admin mengekspor daftar pelanggan via `AdminSubscriberController@export`, setiap nilai string disanitasi menggunakan `App\Services\CsvSanitizer` untuk mencegah eksekusi formula spreadsheet (`=`, `+`, `-`, `@`, `\t`, `\r`).

---

## 7. Domain Jejak Audit (`AuditLogService`)

Setiap tindakan administratif sensitif wajib memanggil:
```php
AuditLogService::log(string $action, string $modelName, mixed $modelId, array $details);
```

### Aksi yang Wajib Dicatat:
- `CONTENT_CREATE`, `CONTENT_UPDATE`, `CONTENT_DELETE`, `CONTENT_STATUS_TOGGLE`
- `COMMENT_APPROVE`, `COMMENT_SPAM`, `COMMENT_DELETE`
- `SUBSCRIBER_DELETE`

Format log mencakup: User ID, Email, IP Address, User-Agent, Model Name, Model ID, Timestamp ISO-8601, dan Details. Catatan audit disimpan ke daily log channel (`storage/logs/laravel-YYYY-MM-DD.log`).
