# [P2][PERF] Optimasi Kueri N+1 Agregasi Bulanan pada ContentController::buildMonthlyChart

**Priority:** P2 (Medium)  
**Labels:** `priority-p2`, `backend`, `enhancement`  
**CWE:** CWE-400 (Uncontrolled Resource Consumption)  

---

## 🐛 Deskripsi Masalah
Pada `app/Http/Controllers/Admin/ContentController.php` baris 236-251, grafik donasi bulanan di-generate melalui loop PHP yang memicu **12 kueri SQL terpisah** setiap kali halaman `/admin/donasi` dimuat:

```php
for ($i = 11; $i >= 0; $i--) {
    $month    = Carbon::now()->startOfMonth()->subMonths($i);
    $labels[] = $month->translatedFormat("M 'y");
    $data[]   = (int) Donation::where('status', 'success')
        ->whereYear('created_at', $month->year)
        ->whereMonth('created_at', $month->month)
        ->sum('amount');
}
```

---

## 💥 Dampak Risiko (Impact)
- Latensi pemuatan dashboard admin meningkat seiring bertambahnya volume baris transaksi donasi.
- Inkonsistensi arsitektur, karena `AdminController.php` baris 61-77 telah menggunakan kueri tunggal yang efisien.

---

## 🛠️ Rekomendasi Solusi
Satukan 12 kueri menjadi **1 kueri agregasi tunggal** menggunakan `groupBy('year_month')`:

```php
private function buildMonthlyChart(): array
{
    $labels = [];
    $data   = [];
    $startDate = Carbon::now()->startOfMonth()->subMonths(11);

    $driver = \DB::getDriverName();
    $dateExpr = $driver === 'sqlite'
        ? "strftime('%Y-%m', created_at) as year_month"
        : "DATE_FORMAT(created_at, '%Y-%m') as year_month";

    $monthlyTotals = Donation::where('status', 'success')
        ->where('created_at', '>=', $startDate)
        ->selectRaw("{$dateExpr}, SUM(amount) as total")
        ->groupBy('year_month')
        ->pluck('total', 'year_month');

    for ($i = 11; $i >= 0; $i--) {
        $month      = Carbon::now()->startOfMonth()->subMonths($i);
        $key        = $month->format('Y-m');
        $labels[]   = $month->translatedFormat("M 'y");
        $data[]     = (int) ($monthlyTotals[$key] ?? 0);
    }

    return [$labels, $data];
}
```

---

## ✅ Kriteria Keberhasilan (Definition of Done)
- [ ] Kueri SQL untuk chart bulanan pada `/admin/donasi` tereduksi dari 12 kueri menjadi 1 kueri.
- [ ] Data grafik tetap tampil presisi untuk driver database MySQL dan SQLite.
