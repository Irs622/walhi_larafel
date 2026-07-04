<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // blog
            [
                'title' => 'Krisis Air di DAS Citarum: Investigasi Lapangan',
                'slug' => 'krisis-air-citarum',
                'body' => 'Investigasi mendalam mengenai pencemaran air di Daerah Aliran Sungai Citarum...',
                'tags' => 'air, citarum, polusi',
                'status' => 'published',
                'image_url' => '',
                'publish_date' => '2025-06-01',
                'category' => 'blog',
            ],
            [
                'title' => 'Deforestasi Masif di Pegunungan Halimun',
                'slug' => 'deforestasi-halimun',
                'body' => 'Laporan penebangan hutan liar yang merusak ekosistem Pegunungan Halimun...',
                'tags' => 'hutan, deforestasi',
                'status' => 'published',
                'image_url' => '',
                'publish_date' => '2025-05-15',
                'category' => 'blog',
            ],
            [
                'title' => 'Menagih Janji Reklamasi Tambang',
                'slug' => 'reklamasi-tambang',
                'body' => 'Analisis komitmen perusahaan tambang dalam melakukan reklamasi lahan pasca-tambang...',
                'tags' => 'tambang, reklamasi',
                'status' => 'draft',
                'image_url' => '',
                'publish_date' => null,
                'category' => 'blog',
            ],
            // regulasi
            [
                'title' => 'UU No. 32 Tahun 2009 — Perlindungan Lingkungan Hidup',
                'slug' => 'uu-32-2009',
                'body' => 'Undang-Undang Republik Indonesia Nomor 32 Tahun 2009 tentang Perlindungan dan Pengelolaan Lingkungan Hidup...',
                'tags' => 'undang-undang',
                'status' => 'published',
                'image_url' => '',
                'publish_date' => '2009-10-03',
                'category' => 'regulasi',
            ],
            [
                'title' => 'PP No. 22 Tahun 2021 — Penyelenggaraan Perlindungan Lingkungan',
                'slug' => 'pp-22-2021',
                'body' => 'Peraturan Pemerintah Nomor 22 Tahun 2021 tentang Penyelenggaraan Perlindungan dan Pengelolaan Lingkungan Hidup...',
                'tags' => 'peraturan pemerintah',
                'status' => 'published',
                'image_url' => '',
                'publish_date' => '2021-02-02',
                'category' => 'regulasi',
            ],
            // siaran-pers
            [
                'title' => 'WALHI Jabar Menolak Izin Tambang di Kawasan Lindung Cianjur',
                'slug' => 'tolak-tambang-cianjur',
                'body' => 'Pernyataan sikap WALHI Jawa Barat menolak keras rencana izin usaha pertambangan...',
                'tags' => 'tambang, siaran pers',
                'status' => 'published',
                'image_url' => '',
                'publish_date' => '2025-06-20',
                'category' => 'siaran-pers',
            ],
            // infografis
            [
                'title' => 'Peta Konflik Agraria Jawa Barat 2024',
                'slug' => 'peta-konflik-agraria-2024',
                'body' => 'Visualisasi data sebaran titik konflik agraria di wilayah Jawa Barat selama tahun 2024...',
                'tags' => 'agraria, peta',
                'status' => 'published',
                'image_url' => '',
                'publish_date' => '2024-12-01',
                'category' => 'infografis',
            ],
            // kertas-posisi
            [
                'title' => 'Posisi WALHI terhadap RUU Pertanahan',
                'slug' => 'posisi-ruu-pertanahan',
                'body' => 'Kertas posisi resmi WALHI Jawa Barat memberikan rekomendasi kritis atas draf RUU Pertanahan...',
                'tags' => 'agraria, posisi',
                'status' => 'published',
                'image_url' => '',
                'publish_date' => '2025-03-10',
                'category' => 'kertas-posisi',
            ],
            // newsletter
            [
                'title' => 'E-Newsletter WALHI Jabar — Edisi Juni 2025',
                'slug' => 'newsletter-juni-2025',
                'body' => 'Berita-berita lingkungan hidup terkini di Jawa Barat edisi Juni 2025...',
                'tags' => 'newsletter',
                'status' => 'published',
                'image_url' => '',
                'publish_date' => '2025-06-30',
                'category' => 'newsletter',
            ],
            // buletin-bumi
            [
                'title' => 'Buletin Bumi Vol. 12 — Keadilan Iklim',
                'slug' => 'buletin-bumi-vol-12',
                'body' => 'Buletin Bumi edisi volume ke-12 fokus pada isu Keadilan Iklim dan dampaknya di daerah...',
                'tags' => 'buletin, iklim',
                'status' => 'published',
                'image_url' => '',
                'publish_date' => '2025-05-01',
                'category' => 'buletin-bumi',
            ],
            // jurnal
            [
                'title' => 'Jurnal Tanah Air — Edisi Khusus Citarum',
                'slug' => 'jurnal-citarum',
                'body' => 'Kumpulan jurnal ilmiah populer tentang restorasi dan sejarah ekologi sungai Citarum...',
                'tags' => 'jurnal, citarum',
                'status' => 'published',
                'image_url' => '',
                'publish_date' => '2025-04-01',
                'category' => 'jurnal',
            ],
            // laporan-tahunan
            [
                'title' => 'Laporan Tahunan WALHI Jabar 2024',
                'slug' => 'laporan-2024',
                'body' => 'Laporan pertanggungjawaban program kerja dan keuangan WALHI Jabar tahun 2024...',
                'tags' => 'laporan',
                'status' => 'published',
                'image_url' => '',
                'publish_date' => '2025-03-01',
                'category' => 'laporan-tahunan',
            ],
            [
                'title' => 'Laporan Tahunan WALHI Jabar 2023',
                'slug' => 'laporan-2023',
                'body' => 'Laporan pertanggungjawaban program kerja dan keuangan WALHI Jabar tahun 2023...',
                'tags' => 'laporan',
                'status' => 'published',
                'image_url' => '',
                'publish_date' => '2024-03-01',
                'category' => 'laporan-tahunan',
            ],
            // donasi
            [
                'title' => 'Kampanye Selamatkan Citarum',
                'slug' => 'kampanye-citarum',
                'body' => 'Target: Rp 50.000.000. Donasi akan dialokasikan untuk pemantauan kualitas air dan edukasi warga DAS...',
                'tags' => 'donasi, citarum',
                'status' => 'published',
                'image_url' => '',
                'publish_date' => '2025-01-01',
                'category' => 'donasi',
            ],
            // pekan-rakyat
            [
                'title' => 'Pekan Rakyat Lingkungan Hidup 2025',
                'slug' => 'pekan-rakyat-2025',
                'body' => 'Bandung, 15–20 Agustus 2025. Rangkaian pameran foto, diskusi publik, dan festival seni...',
                'tags' => 'event, pekan rakyat',
                'status' => 'published',
                'image_url' => '',
                'publish_date' => '2025-08-15',
                'category' => 'pekan-rakyat',
            ],
            // sejarah
            [
                'title' => 'Sejarah WALHI Jawa Barat',
                'slug' => 'sejarah',
                'body' => 'WALHI Jawa Barat berdiri pada tahun 1990 sebagai respons atas meningkatnya konflik lingkungan...',
                'tags' => 'sejarah',
                'status' => 'published',
                'image_url' => '',
                'publish_date' => '1990-01-01',
                'category' => 'sejarah',
            ],
            // visi-misi
            [
                'title' => 'Visi dan Misi WALHI Jabar',
                'slug' => 'visi-misi',
                'body' => 'Visi: Terwujudnya tatanan sosial, ekonomi, dan politik yang adil serta demokratis yang menjamin hak rakyat atas lingkungan hidup...',
                'tags' => 'visi, misi',
                'status' => 'published',
                'image_url' => '',
                'publish_date' => '2024-01-01',
                'category' => 'visi-misi',
            ],
            // kontak
            [
                'title' => 'Informasi Kontak WALHI Jabar',
                'slug' => 'kontak',
                'body' => 'Alamat: Jl. Tubagus Ismail No. 16, Bandung. Telepon: (022) 1234567. Email: jabar@walhi.or.id',
                'tags' => 'kontak',
                'status' => 'published',
                'image_url' => '',
                'publish_date' => '2024-01-01',
                'category' => 'kontak',
            ],
        ];

        foreach ($data as $item) {
            Content::create($item);
        }
    }
}
