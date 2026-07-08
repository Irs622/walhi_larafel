# Kebijakan Keamanan & Pedoman Coding Aman (Security Policy & Secure Coding Guidelines)

Dokumen ini berisi pedoman keamanan untuk pengembangan aplikasi WALHI, termasuk aturan penulisan kueri database, penanganan eror, dan konfigurasi Web Application Firewall (WAF) untuk server produksi.

---

## 1. Aturan Penulisan Kueri Database (Database Security & SQL Injection Prevention)

Setiap pengembang (dan sub-agen kecerdasan buatan) wajib mematuhi aturan berikut saat berinteraksi dengan database untuk mencegah kerentanan **SQL Injection (SQLi)**:

### A. Wajib Menggunakan Prepared Statements (Parameter Binding)
Jangan pernah menggabungkan (concatenate) input pengguna langsung ke dalam string SQL. Gunakan fitur bawaan Laravel Eloquent ORM atau Query Builder yang secara otomatis mengamankan kueri menggunakan Prepared Statements.

*   **❌ SALAH (Rentan SQLi):**
    ```php
    $email = $request->input('email');
    // Rentan terhadap manipulasi SQL via variabel $email
    $users = DB::select("SELECT * FROM users WHERE email = '" . $email . "'");
    
    // Rentan jika menggunakan whereRaw tanpa bindings
    $posts = Post::whereRaw("title LIKE '%" . $request->search . "%'")->get();
    ```

*   **✅ BENAR (Menggunakan Parameter Binding):**
    ```php
    $email = $request->input('email');
    
    // Menggunakan DB::select dengan binding (?)
    $users = DB::select("SELECT * FROM users WHERE email = ?", [$email]);
    
    // Menggunakan Eloquent ORM (Sangat direkomendasikan)
    $users = User::where('email', $email)->get();
    
    // Menggunakan whereRaw dengan bindings
    $posts = Post::whereRaw("title LIKE ?", ["%" . $request->search . "%"])->get();
    ```

### B. Hindari Query Mentah (Raw Query) yang Tidak Perlu
Gunakan Query Builder Laravel seperti `where()`, `join()`, `insert()`, `update()` karena metode ini aman secara default. Jika terpaksa menggunakan `DB::raw()`, pastikan nilai di dalamnya tidak mengandung input mentah dari request.

---

## 2. Penanganan Error Database di Produksi (Preventing Error-Based SQLi)

Di lingkungan produksi (production), informasi internal database seperti nama tabel, nama kolom, atau kueri SQL yang gagal **tidak boleh bocor** ke pengguna. Kebocoran ini dapat dimanfaatkan penyerang untuk memetakan database (Error-based SQLi).

### A. Nonaktifkan Debug Mode di Produksi
Pastikan file `.env` di server produksi dikonfigurasi sebagai berikut:
```env
APP_ENV=production
APP_DEBUG=false
```

### B. Penanganan Global Database Exception
Kami telah mengonfigurasi handler exception global di [bootstrap/app.php](file:///Users/mac/clone%20walhi/walhi_larafel/bootstrap/app.php) untuk menangkap `QueryException` dan `PDOException`. 

Jika terjadi error database dan `APP_DEBUG` bernilai `false`:
1.  Sistem akan mencatat (log) detail error secara lengkap dan aman di `storage/logs/laravel.log` (hanya dapat diakses oleh administrator).
2.  Sistem akan mengembalikan respon JSON generic `{"message": "Internal Server Error: A database operation failed."}` untuk API request, atau menampilkan halaman error 500 generik untuk request web biasa.

---

## 3. Rekomendasi Konfigurasi Web Application Firewall (WAF) Sederhana

Untuk mengamankan server deployment WALHI dari serangan SQLi, XSS, dan Brute Force secara otomatis sebelum request mencapai aplikasi Laravel, berikut adalah beberapa opsi WAF sederhana yang dapat dipasang:

### Opsi A: Menggunakan Cloudflare WAF (Paling Mudah & Praktis)
Jika domain WALHI diarahkan melalui Cloudflare (sebagai reverse proxy):
1.  Aktifkan status **Proxy (Orange Cloud)** pada DNS records Anda.
2.  Masuk ke menu **Security > WAF > Firewall Rules** (atau **Custom Rules**).
3.  Aktifkan Managed Ruleset dasar (OWASP Core Ruleset) bawaan Cloudflare.
4.  Buat Custom Rule untuk memblokir request yang mengandung pola mencurigakan atau akses ke file sensitif seperti `.env`:
    *   **Field:** `URI Path`
    *   **Operator:** `contains`
    *   **Value:** `/.env`
    *   **Action:** `Block`

---

### Opsi B: Konfigurasi Keamanan Nginx (Jika Menggunakan Nginx Web Server)
Tambahkan aturan berikut di dalam blok `server` pada file konfigurasi Nginx Anda (misal `/etc/nginx/sites-available/walhi`) untuk memblokir pola SQL Injection dasar:

```nginx
# 1. Blokir akses langsung ke file sensitif
location ~ /\.(env|git|htaccess|composer) {
    deny all;
    return 404;
}

# 2. Filter SQL Injection dasar pada URI dan Query String
if ($query_string ~* "union.*select.*\(") {
    return 403;
}
if ($query_string ~* "concat.*\(") {
    return 403;
}
if ($query_string ~* "select.*from") {
    return 403;
}
if ($query_string ~* "insert.*into") {
    return 403;
}
if ($query_string ~* "delete.*from") {
    return 403;
}
if ($query_string ~* "update.*set") {
    return 403;
}

# 3. Blokir karakter mencurigakan yang biasa dipakai SQLi
if ($query_string ~* "['\"].*(or|and).*['\"].*=.*['\"]") {
    return 403;
}
```

Setelah menambahkan konfigurasi di atas, jalankan:
```bash
sudo nginx -t
sudo systemctl reload nginx
```

---

### Opsi C: Memasang ModSecurity (WAF Open-Source Tingkat Lanjut)
Jika Anda menggunakan VPS Linux dan ingin proteksi WAF penuh di tingkat web server:

1.  **Instalasi ModSecurity (Ubuntu/Debian):**
    ```bash
    sudo apt update
    sudo apt install libnginx-mod-security2 modsecurity-crs -y
    ```
2.  **Konfigurasi ModSecurity:**
    Salin file konfigurasi bawaan dan aktifkan WAF:
    ```bash
    sudo cp /etc/modsecurity/modsecurity.conf-recommended /etc/modsecurity/modsecurity.conf
    # Ubah "SecRuleEngine DetectionOnly" menjadi "SecRuleEngine On" di /etc/modsecurity/modsecurity.conf
    sudo sed -i 's/SecRuleEngine DetectionOnly/SecRuleEngine On/' /etc/modsecurity/modsecurity.conf
    ```
3.  **Hubungkan dengan Nginx:**
    Pastikan ModSecurity aktif pada blok server Nginx Anda:
    ```nginx
    server {
        ...
        modsecurity on;
        modsecurity_rules_file /etc/nginx/modsec/main.conf;
    }
    ```
    *(Gunakan OWASP Core Rule Set (CRS) yang terpasang otomatis untuk memblokir SQLi, XSS, LFI/RFI, dan injeksi kode lainnya).*
