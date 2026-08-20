# [P3][DATABASE] Tambahkan Migration Indeks Komposit pada Tabel Comments untuk Optimasi Threading

**Priority:** P3 (Low)  
**Labels:** `priority-p3`, `backend`, `enhancement`  
**CWE:** CWE-400 (Uncontrolled Resource Consumption)  

---

## 🐛 Deskripsi Masalah
Query pemanggilan komentar di `app/Http/Controllers/PublicContentController.php` baris 90-95 memfilter berdasarkan `content_id`, `status='approved'`, dan `parent_id IS NULL` secara bersamaan. Namun, pada migrasi `database/migrations/2026_07_06_114428_create_comments_table.php` indeks komposit belum tersedia.

---

## 🛠️ Rekomendasi Solusi
Buat migration baru untuk menambahkan indeks komposit:
```php
Schema::table('comments', function (Blueprint $table) {
    $table->index(['content_id', 'status', 'parent_id'], 'idx_comments_content_status_parent');
    $table->index(['parent_id', 'status', 'created_at'], 'idx_comments_parent_status_created');
});
```

---

## ✅ Kriteria Keberhasilan (Definition of Done)
- [ ] Migration berjalan sukses dan `EXPLAIN` query komentar memanfaatkan indeks komposit baru.
