# [P2][SECURITY] Perluas Filter Karakter CSV Formula Injection pada Fitur Ekspor Newsletter

**Priority:** P2 (Medium)  
**Labels:** `priority-p2`, `security`, `backend`, `hardening`  
**CWE:** CWE-1236 (Improper Neutralization of Formula Elements in CSV File)  
**OWASP:** A03:2021 – Injection  

---

## 🐛 Deskripsi Masalah
Pada `app/Http/Controllers/Admin/AdminSubscriberController.php` baris 39-41:
```php
$email = $subscriber->email;
if (in_array(substr($email, 0, 1), ['=', '+', '-', '@'], true)) {
    $email = "'" . $email;
}
```
Sanitasi saat ini baru mencakup prefix formula dasar (`=`, `+`, `-`, `@`), namun belum mencakup karakter separator dan command trigger Excel lainnya seperti Tab (`\t`), Carriage Return (`\r`), Line Feed (`\n`), Pipe (`|`), atau `%`.

---

## 💥 Dampak Risiko (Impact)
- Potensi eksploitasi *CSV / Formula Injection (CWE-1236)* jika penyerang menyisipkan payload DDE formula melalui form pendaftaran newsletter publik dan file CSV dibuka oleh staf admin di Microsoft Excel / LibreOffice.

---

## 🛠️ Rekomendasi Solusi
Perluas daftar karakter prefix berbahaya:

```php
$dangerousPrefixes = ['=', '+', '-', '@', "\t", "\r", "\n", '|', '%'];
if (in_array(substr($email, 0, 1), $dangerousPrefixes, true)) {
    $email = "'" . $email;
}
```

---

## ✅ Kriteria Keberhasilan (Definition of Done)
- [ ] Seluruh karakter trigger formula spreadsheet dinetralkan dengan prepending apostrof `'`.
