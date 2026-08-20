<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Content;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ImportWpCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:wp-csv 
                            {--file=database/data/data-migasi-bersih.csv : Path to the WordPress export CSV file}
                            {--dry-run : Analyze the CSV file without importing data}
                            {--truncate : Truncate the contents table before importing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import and clean WordPress data from a CSV file into the contents table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->option('file');
        $dryRun = $this->option('dry-run');
        $truncate = $this->option('truncate');

        $this->info("=== MEMULAI IMPORT DATA WORDPRESS CSV ===");
        $this->line("File path: " . $filePath);

        if (!file_exists($filePath)) {
            $this->error("File CSV tidak ditemukan pada path: " . $filePath);
            $this->line("Silakan spesifikasikan path menggunakan opsi --file, contoh:");
            $this->line("php artisan import:wp-csv --file=/path/to/your/file.csv");
            return Command::FAILURE;
        }

        // Buka file CSV
        if (($handle = fopen($filePath, "r")) === false) {
            $this->error("Gagal membuka file CSV.");
            return Command::FAILURE;
        }

        // Membaca header
        $headers = fgetcsv($handle, 0, ',', '"', "");
        if (!$headers) {
            $this->error("File CSV kosong atau tidak valid.");
            fclose($handle);
            return Command::FAILURE;
        }

        // Tampilkan info kolom
        $this->line("Kolom terdeteksi: " . implode(', ', $headers));

        // Pengolahan awal untuk analisis statistik
        $typeDistribution = [];
        $statusDistribution = [];
        $rows = [];
        $rowCount = 0;

        while (($data = fgetcsv($handle, 0, ',', '"', "")) !== false) {
            $rowCount++;
            // Map row dengan header
            $row = array_combine(array_slice($headers, 0, count($data)), array_slice($data, 0, count($headers)));
            
            // Hitung distribusi type dan status
            $type = $row['type'] ?? 'unknown';
            $status = $row['status'] ?? 'unknown';
            
            $typeDistribution[$type] = ($typeDistribution[$type] ?? 0) + 1;
            $statusDistribution[$status] = ($statusDistribution[$status] ?? 0) + 1;
            
            if ($rowCount <= 5) {
                $rows[] = $row;
            }
        }
        rewind($handle);
        fgetcsv($handle, 0, ',', '"', ""); // skip header lagi

        $this->info("\n=== HASIL ANALISIS CSV ===");
        $this->line("Total Baris Data: " . $rowCount);
        $this->line("Distribusi Kolom 'type' (WordPress):");
        foreach ($typeDistribution as $t => $count) {
            $this->line("  - Type '{$t}': {$count} baris");
        }
        $this->line("Distribusi Kolom 'status' (WordPress):");
        foreach ($statusDistribution as $s => $count) {
            $this->line("  - Status '{$s}': {$count} baris");
        }

        if ($dryRun) {
            $this->info("\n=== DRY RUN AKTIF: CONTOH PEMBERSIHAN DATA ===");
            foreach ($rows as $index => $row) {
                $this->comment("\n--- Baris Contoh #" . ($index + 1) . " ---");
                $this->line("Judul Asli: " . ($row['title'] ?? ''));
                $this->line("Slug Asli: " . ($row['slug'] ?? ''));
                $this->line("Tanggal Publish: " . ($row['publish_date'] ?? ''));
                
                // Demo Pembersihan
                $cleanedBody = $this->cleanWordPressContent($row['content'] ?? '');
                $mappedCategory = $this->mapCategory($row['title'] ?? '', $row['slug'] ?? '', $row['type'] ?? '');
                $mappedStatus = (($row['status'] ?? '') == '1') ? 'published' : 'draft';
                $imageUrl = (($row['thumbnail'] ?? '') !== 'default_news.jpg') ? $row['thumbnail'] : null;

                $this->line("Kategori Terpetakan: " . $mappedCategory);
                $this->line("Status Terpetakan: " . $mappedStatus);
                $this->line("Image URL Terpetakan: " . ($imageUrl ?? 'NULL (Menggunakan default)'));
                $this->line("Contoh Potongan Body Terbersih (150 karakter): " . Str::limit(strip_tags($cleanedBody), 150));
            }
            
            $this->info("\nDry run selesai. Tidak ada data yang dimasukkan ke database.");
            fclose($handle);
            return Command::SUCCESS;
        }

        // Jalankan Truncate jika diminta
        if ($truncate) {
            $this->warn("\nMengosongkan tabel 'contents'...");
            $driver = DB::connection()->getDriverName();
            if ($driver === 'sqlite') {
                DB::statement('PRAGMA foreign_keys = OFF;');
            } else {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            }
            
            Content::truncate();
            
            if ($driver === 'sqlite') {
                DB::statement('PRAGMA foreign_keys = ON;');
            } else {
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }
            $this->info("Tabel 'contents' berhasil dikosongkan.");
        }

        $this->info("\n=== MEMPROSES IMPOR DATA KE DATABASE ===");
        $importedCount = 0;
        $failedCount = 0;

        $bar = $this->output->createProgressBar($rowCount);
        $bar->start();

        while (($data = fgetcsv($handle, 0, ',', '"', "")) !== false) {
            // Gabungkan header dan data
            if (count($data) < count($headers)) {
                // Pad data jika kolom kurang
                $data = array_pad($data, count($headers), '');
            }
            $row = array_combine(array_slice($headers, 0, count($data)), array_slice($data, 0, count($headers)));

            try {
                $title = $row['title'] ?? '';
                if (empty($title)) {
                    $failedCount++;
                    $bar->advance();
                    continue;
                }

                $slug = $row['slug'] ?? Str::slug($title);
                
                // Pastikan slug unik di database untuk mencegah error constraint
                $originalSlug = $slug;
                $slugCounter = 1;
                while (Content::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $slugCounter;
                    $slugCounter++;
                }

                // Bersihkan body berita
                $cleanedBody = $this->cleanWordPressContent($row['content'] ?? '');

                // Petakan kategori
                $mappedCategory = $this->mapCategory($title, $slug, $row['type'] ?? '');

                // Petakan status (1 = published, lainnya = draft)
                $mappedStatus = (($row['status'] ?? '') == '1') ? 'published' : 'draft';

                // Petakan image url
                $imageUrl = (($row['thumbnail'] ?? '') !== 'default_news.jpg') ? $row['thumbnail'] : null;

                // Masukkan ke database
                Content::create([
                    'title' => $title,
                    'slug' => $slug,
                    'body' => $cleanedBody,
                    'tags' => null, // WordPress tags tidak dipetakan langsung dari CSV ini
                    'status' => $mappedStatus,
                    'image_url' => $imageUrl,
                    'publish_date' => !empty($row['publish_date']) ? $row['publish_date'] : null,
                    'category' => $mappedCategory,
                ]);

                $importedCount++;
            } catch (\Exception $e) {
                $failedCount++;
                // Simpan log error secara internal
                \Log::error("Gagal mengimpor baris CSV: " . ($row['title'] ?? '') . ". Error: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        fclose($handle);

        $this->info("\n\n=== PROSES IMPOR SELESAI ===");
        $this->info("Berhasil diimpor: {$importedCount} baris");
        if ($failedCount > 0) {
            $this->warn("Gagal diimpor: {$failedCount} baris (cek storage/logs/laravel.log untuk detail)");
        }

        return Command::SUCCESS;
    }

    /**
     * Bersihkan konten HTML WordPress dari Gutenberg blocks, HTML comments, dan shortcodes.
     */
    private function cleanWordPressContent(string $content): string
    {
        // 1. Hapus seluruh komentar HTML (termasuk Gutenberg blocks: <!-- wp:paragraph --> dll.)
        $cleaned = preg_replace('/<!--(.*?)-->/s', '', $content);

        // 2. Bersihkan shortcode WordPress yang umum:
        // [caption]...[/caption] -> diganti menjadi <figure class="my-4 text-center">...</figure>
        $cleaned = preg_replace('/\[caption[^\]]*\](.*?)\[\/caption\]/is', '<figure class="my-4 text-center">$1</figure>', $cleaned);

        // [embed]...[/embed] -> diganti menjadi responsive video container
        $cleaned = preg_replace('/\[embed[^\]]*\](.*?)\[\/embed\]/is', '<div class="video-container my-4">$1</div>', $cleaned);

        // Hapus shortcode [gallery] karena biasanya gambarnya dimigrasikan secara manual
        $cleaned = preg_replace('/\[gallery[^\]]*\]/is', '', $cleaned);

        // Hapus semua shortcode tak dikenal lainnya (menghilangkan bracket tag [ ] beserta isinya)
        $cleaned = preg_replace('/\[\/?\w+[^\]]*\]/', '', $cleaned);

        // 3. Normalisasi tag paragraf dan baris kosong ganda yang tidak rapi
        $cleaned = preg_replace('/(<br\s*\/?>\s*)+/', '<br />', $cleaned);

        // 4. Hilangkan style inline font-size bawaan editor lama agar konsisten dengan CSS baru
        $cleaned = preg_replace('/style\s*=\s*"[^"]*font-size[^"]*"/i', '', $cleaned);

        return trim($cleaned);
    }

    /**
     * Memetakan tipe/kategori WordPress menjadi kategori yang valid di aplikasi Laravel baru.
     */
    private function mapCategory(string $title, string $slug, string $wpType): string
    {
        $titleLower = strtolower($title);
        $slugLower = strtolower($slug);

        // Heuristic mapping berdasarkan judul dan slug
        if (str_contains($titleLower, 'siaran pers') || str_contains($titleLower, 'siaran-pers') || str_contains($slugLower, 'siaran-pers')) {
            return 'siaran-pers';
        }

        if (str_contains($titleLower, 'regulasi') || str_contains($slugLower, 'regulasi') || 
            preg_match('/\buu\b|\bpp\b|\bundang-undang\b|\bperaturan\b/', $titleLower)) {
            return 'regulasi';
        }

        if (str_contains($titleLower, 'laporan tahunan') || str_contains($titleLower, 'annual report') || str_contains($slugLower, 'laporan-tahunan')) {
            return 'laporan-tahunan';
        }

        if (str_contains($titleLower, 'infografis') || str_contains($slugLower, 'infografis') || str_contains($titleLower, 'visualisasi')) {
            return 'infografis';
        }

        if (str_contains($titleLower, 'kertas posisi') || str_contains($slugLower, 'kertas-posisi')) {
            return 'kertas-posisi';
        }

        if (str_contains($titleLower, 'newsletter') || str_contains($slugLower, 'newsletter')) {
            return 'newsletter';
        }

        if (str_contains($titleLower, 'buletin bumi') || str_contains($slugLower, 'buletin-bumi')) {
            return 'buletin-bumi';
        }

        if (str_contains($titleLower, 'jurnal') || str_contains($slugLower, 'jurnal')) {
            return 'jurnal';
        }

        if ($slugLower === 'sejarah' || str_contains($titleLower, 'sejarah')) {
            return 'sejarah';
        }

        if ($slugLower === 'visi-misi' || str_contains($titleLower, 'visi dan misi') || str_contains($titleLower, 'visi & misi')) {
            return 'visi-misi';
        }

        if ($slugLower === 'kontak' || $slugLower === 'contact') {
            return 'kontak';
        }

        // Pemetaan cadangan jika tipe WordPress terdefinisi khusus
        if ($wpType == '2') {
            return 'blog'; // Kebanyakan post berita masuk blog
        }
        
        if ($wpType == '4') {
            // Bisa berupa profil atau pages statis
            if (str_contains($titleLower, 'profil') || str_contains($titleLower, 'tentang')) {
                return 'sejarah'; 
            }
            return 'blog';
        }

        return 'blog'; // Default fallback
    }
}
