# Kebijakan Keamanan (Security Policy)

Wahana Lingkungan Hidup Indonesia — Jawa Barat (WALHI Jawa Barat) berkomitmen untuk menjaga keamanan dan privasi data anggota, jurnalis, pegiat lingkungan, donatur, serta seluruh pengguna platform web ini.

Dokumen ini menjelaskan kebijakan pelaporan kerentanan keamanan (*Responsible & Coordinated Vulnerability Disclosure*), versi yang didukung, serta komitmen standar pengamanan sistem kami.

---

## 🛡️ Versi yang Didukung (Supported Versions)

Kami secara aktif memelihara dan memberikan pembaruan keamanan (*security patches*) untuk rilis berikut:

| Versi | Didukung Pembaruan Keamanan |
| :--- | :---: |
| **v1.x (Laravel 12.x / PHP 8.4)** | :white_check_mark: Ya |
| **< v1.0** | :x: Tidak |

---

## 🚨 Prosedur Pelaporan Kerentanan (Reporting a Vulnerability)

Jika Anda menemukan celah keamanan (*vulnerability*) pada aplikasi atau infrastruktur WALHI Jawa Barat, kami sangat menghargai kerja sama Anda untuk melaporkannya secara bertanggung jawab (*Responsible Disclosure*).

### 1. Kanal Pelaporan Resmi
Kirimkan laporan teknis lengkap Anda ke alamat email:
📧 **kontak@walhijabar.org** *(Cc: **kontak@walhijabar.or.id**)*  
**Subjek:** `[SECURITY] Laporan Kerentanan - [Komponen Terkait]`

### 2. Informasi yang Diperlukan
Untuk mempercepat proses investigasi dan mitigasi, mohon sertakan:
- **Deskripsi & Dampak:** Penjelasan mengenai jenis kerentanan dan potensi risiko yang ditimbulkan.
- **Langkah Reproduksi (PoC):** Langkah-langkah detail agar tim teknis kami dapat mereproduksi celah tersebut.
- **Tangkapan Layar / Log:** Bukti pengujian (tanpa merusak integritas data sistem yang sedang berjalan).
- **Saran Perbaikan:** Rekomendasi teknis mitigasi (jika ada).

### 3. Etika & Ketentuan Pelaporan (*Disclosure Guidelines*)
- **JANGAN** mempublikasikan detail kerentanan ke ranah publik (GitHub Issues, media sosial, atau blog) sebelum perbaikan resmi dirilis.
- **JANGAN** mengakses, mengubah, atau menghapus data pengguna nyata tanpa izin.
- **JANGAN** melakukan serangan *Denial of Service (DoS/DDoS)* atau tindakan yang dapat mengganggu ketersediaan layanan publik.

### 4. Komitmen & SLA Penanganan Kami
- **Konfirmasi Penerimaan:** Tim teknis kami akan merespons dan mengonfirmasi laporan Anda dalam waktu maksimal **48 jam**.
- **Investigasi & Validasi:** Tim akan menganalisis tingkat keparahan (*Severity Assessment*) dan menguji PoC yang dikirimkan.
- **Perilisan Patch:** Perbaikan akan segera diterapkan ke branch utama dan server produksi sesegera mungkin.
- **Penghargaan (Acknowledgement):** Kami sangat mengapresiasi dan akan mencantumkan kontribusi Anda pada catatan rilis (*Release Notes*) jika diinginkan.

---

## 🔒 Standar Praktik Keamanan Platform

Secara arsitektural, platform web ini mengadopsi standar pengamanan berlapis (*Defense-in-Depth*):

1. **Proteksi Injeksi SQL & Input Sanitization:** Seluruh interaksi basis data wajib menggunakan *Prepared Statements* (Eloquent ORM & PDO parameter bindings) serta sanitasi input otomatis via Form Request Validation dan HTMLPurifier.
2. **Proteksi Sesi & CSRF:** Seluruh permintaan mutasi data (POST/PUT/DELETE) dilindungi oleh *CSRF Token Validation*, cookie sesi terenkripsi (*encrypted sessions*), dan atribut `HttpOnly` serta `SameSite=Lax`.
3. **HTTP Security Headers:** Penerapan *Content Security Policy (CSP)*, *X-Content-Type-Options: nosniff*, *X-Frame-Options: SAMEORIGIN*, dan *Referrer-Policy* untuk mencegah serangan XSS, Clickjacking, dan MIME-sniffing.
4. **Isolasi Lingkungan Produksi:** Penonaktifan *Debug Mode* (`APP_DEBUG=false`) secara mutlak pada lingkungan live guna mencegah *Error-based Information Leakage*.
5. **Autentikasi & Otorisasi Ketat:** Pembatasan hak akses berbasis peran (*Role-Based Access Control*) dan kebijakan otorisasi (*Laravel Policies*) pada seluruh modul administratif.

