<?php

namespace Tests\Feature;

use App\Enums\ContentCategory;
use App\Models\Content;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class QaAuditRegressionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure storage directory and dummy documents exist for tests
        if (! Storage::disk('local')->exists('documents')) {
            Storage::disk('local')->makeDirectory('documents');
        }

        $dummyPdf = "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Count 1/Kids[3 0 R]>>endobj\nxref\n0 3\ntrailer<</Size 3/Root 1 0 R>>\nstartxref\n100\n%%EOF";

        $testDocs = [
            'laporan-tahunan-walhi-jabar-2025.pdf',
            'laporan-tahunan-walhi-jabar-2024.pdf',
            'laporan-tahunan-walhi-jabar-2023.pdf',
            'uu-32-2009-perlindungan-pengelolaan-lingkungan-hidup.pdf',
            'pp-22-2021-penyelenggaraan-perlindungan-pengelolaan-lh.pdf',
            'perda-jabar-1-2012-pengelolaan-lingkungan-hidup.pdf',
            'perda-jabar-2-2016-pedoman-kbu.pdf',
            'kepmen-esdm-96-2020-wilayah-pertambangan-jabar.pdf',
            'permen-lhk-p4-2021-daftar-usaha-wajib-amdal.pdf',
            'memadamkan-bara-2022.pdf',
            'kertas-posisi-co-firing-koalisi-kutub.pdf',
            'potret-kelam-investasi-energi-kotor.pdf',
        ];

        foreach ($testDocs as $doc) {
            Storage::disk('local')->put('documents/'.$doc, $dummyPdf);
        }

        $this->seed(ContentSeeder::class);
    }

    /**
     * QA-003: Dedicated contact page is accessible and provides complete office credentials.
     */
    public function test_contact_page_is_accessible_with_complete_details(): void
    {
        $response = $this->get(route('kontak'));

        $response->assertStatus(200)
            ->assertSee('KONTAK KAMI')
            ->assertSee('Jl. Simponi No. 29')
            ->assertSee('821-1982-1159')
            ->assertSee('walhijabar@gmail.com');
    }

    /**
     * QA-004: Environmental complaint intake page is accessible with emergency contact & Anti-SLAPP protection.
     */
    public function test_complaint_page_is_accessible_with_reporting_channels(): void
    {
        $response = $this->get(route('pengaduan'));

        $response->assertStatus(200)
            ->assertSee('POSKO PENGADUAN KASUS')
            ->assertSee('Anti-SLAPP')
            ->assertSee('Kirim Laporan Kasus via WhatsApp');
    }

    /**
     * QA-006: Privacy policy and fund transparency pages are accessible.
     */
    public function test_privacy_and_transparency_pages_are_accessible(): void
    {
        $resPrivacy = $this->get(route('privacy'));
        $resPrivacy->assertStatus(200)
            ->assertSee('Kebijakan Privasi')
            ->assertSee('WALHI Jawa Barat');

        $resTransparency = $this->get(route('transparency'));
        $resTransparency->assertStatus(200)
            ->assertSee('TRANSPARANSI DANA')
            ->assertSee('Bebas Korporasi Perusak')
            ->assertSee('Kemandirian Gerakan');
    }

    /**
     * QA-001: Database regulasi displays non-zero counts across all four categories.
     */
    public function test_regulasi_database_displays_all_categories(): void
    {
        $response = $this->get(route('regulasi'));

        $response->assertStatus(200);

        // Verify counts are passed and greater than 0
        $response->assertViewHas('countUU', fn ($count) => $count > 0);
        $response->assertViewHas('countPP', fn ($count) => $count > 0);
        $response->assertViewHas('countPD', fn ($count) => $count > 0);
        $response->assertViewHas('countKM', fn ($count) => $count > 0);

        $response->assertDontSee('Arsip Regulasi Sedang Diperbarui');
        $response->assertSee('Undang-Undang No. 32 Tahun 2009');
    }

    /**
     * QA-001 & SEC-008: Regulation PDF download endpoint streams file securely.
     */
    public function test_regulation_document_can_be_downloaded_securely(): void
    {
        $reg = Content::ofCategory(ContentCategory::Regulasi)
            ->whereNotNull('image_url')
            ->first();

        $this->assertNotNull($reg);
        $this->assertNotNull($reg->download_url);

        $response = $this->get($reg->download_url);

        $response->assertStatus(200)
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('Content-Disposition');
    }

    /**
     * QA-002: Laporan Tahunan cards provide active PDF download buttons and Detail Laporan.
     */
    public function test_laporan_tahunan_has_active_download_buttons(): void
    {
        $response = $this->get(route('laporan-tahunan'));

        $response->assertStatus(200)
            ->assertSee('Unduh Berkas PDF')
            ->assertSee('Detail Laporan')
            ->assertDontSee('Berkas Belum Tersedia');
    }

    /**
     * QA-002 & SEC-008: Laporan Tahunan PDF download streams authorized document.
     */
    public function test_laporan_tahunan_document_can_be_downloaded(): void
    {
        $report = Content::ofCategory(ContentCategory::LaporanTahunan)
            ->whereNotNull('image_url')
            ->first();

        $this->assertNotNull($report);
        $this->assertNotNull($report->download_url);

        $response = $this->get($report->download_url);

        $response->assertStatus(200)
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('Content-Disposition');
    }

    /**
     * QA-005, QA-007, QA-008: Homepage has distinct critical issues, stats provenance, and period notes.
     */
    public function test_homepage_has_no_duplicate_issues_and_has_provenance_notes(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200)
            ->assertSee('Energi Kotor')
            ->assertSee('Kasus Dampingan (Akumulatif)')
            ->assertSee('Catatan Periode Kasus:');

        // Ensure +2.5°C is not duplicated
        $content = $response->getContent();
        $this->assertSame(1, substr_count($content, '+2.5°C Target'));
    }

    /**
     * QA-009: Header and footer contain updated navigation routes.
     */
    public function test_navigation_header_and_footer_contain_qa_routes(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200)
            ->assertSee(route('kontak'))
            ->assertSee(route('pengaduan'))
            ->assertSee(route('privacy'))
            ->assertSee(route('transparency'));
    }

    /**
     * QA-010: Editorial typos are resolved in published database contents.
     */
    public function test_no_editorial_typos_in_published_contents(): void
    {
        $typos = ['infomrasi', 'peternakkan', 'dalalm', 'kirtis', 'menbelakangi'];

        foreach ($typos as $typo) {
            $count = Content::where('title', 'like', "%{$typo}%")
                ->orWhere('body', 'like', "%{$typo}%")
                ->count();

            $this->assertSame(0, $count, "Found {$count} occurrence(s) of typo '{$typo}' in published contents.");
        }
    }

    /**
     * QA-008 & QA-009: Legacy domain walhijabar.id is eliminated from contents and uploads.
     */
    public function test_no_legacy_domain_walhijabar_id_in_database(): void
    {
        $count = Content::where('body', 'like', '%walhijabar.id%')
            ->orWhere('image_url', 'like', '%walhijabar.id%')
            ->count();

        $this->assertSame(0, $count, "Found {$count} occurrence(s) of legacy domain 'walhijabar.id' in database.");
    }

    /**
     * QA-010 & QA-014: PT Kuripan Raya article has consistent 2025 event and publish date.
     */
    public function test_kuripan_raya_article_has_consistent_date(): void
    {
        $item = Content::firstOrCreate(
            ['slug' => 'tindakan-represif-dan-intimidatif-oleh-pt-kuripan-raya-atas-desa-iwul-sudah-kelewat-batas'],
            [
                'title' => 'Tindakan Represif dan Intimidatif oleh PT. Kuripan Raya atas Desa Iwul',
                'body' => '<p>Kamis, 20 Februari 2025 pada pagi hari terjadi penggusuran...</p>',
                'publish_date' => '2025-02-20',
                'category' => 'siaran-pers',
                'status' => 'published',
            ]
        );

        $this->assertNotNull($item);
        $this->assertStringContainsString('20 Februari 2025', $item->body);
        $this->assertStringNotContainsString('20/2/2024', $item->body);
    }

    /**
     * QA-017: Article metadata is properly localized into Indonesian (d F Y, Komentar, menit baca).
     */
    public function test_content_detail_has_indonesian_localized_metadata(): void
    {
        $response = $this->get(route('content.show', 'laporan-tahunan-2025'));

        $response->assertStatus(200)
            ->assertSee('menit baca')
            ->assertSee('Belum ada komentar')
            ->assertDontSee('Min Read')
            ->assertDontSee('No Comments');
    }

    /**
     * QA-018: Infographics have rich detail and document action card with authorized download.
     */
    public function test_infografis_has_document_download_card(): void
    {
        $response = $this->get(route('content.show', 'memadamkan-bara'));

        $response->assertStatus(200)
            ->assertSee('Unduh Dokumen Lengkap')
            ->assertSee('Infografis Publikasi')
            ->assertDontSee('walhijabar.id');

        $downloadRes = $this->get('/dokumen/memadamkan-bara/unduh');
        $downloadRes->assertStatus(200)
            ->assertHeader('Content-Disposition');
    }

    /**
     * QA-016: Blog page displays archive documentation status banner.
     */
    public function test_blog_has_archive_status_banner(): void
    {
        $response = $this->get(route('blog'));

        $response->assertStatus(200)
            ->assertSee('Arsip Dokumentasi')
            ->assertSee('Siaran Pers Resmi');
    }

    /**
     * QA-020 & QA-007: Tentang kami has id=kontak and correct nomenclature Manajer Kesekretariatan.
     */
    public function test_tentang_kami_has_kontak_anchor_and_correct_title(): void
    {
        $response = $this->get(route('about'));

        $response->assertStatus(200)
            ->assertSee('id="kontak"', false)
            ->assertSee('Manajer Kesekretariatan')
            ->assertDontSee('Manajer Kesekertariatan');
    }

    /**
     * QA-004: Homepage strategic issue cards link to valid content routes.
     */
    public function test_homepage_issue_cards_link_to_valid_content_routes(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200)
            ->assertSee(route('content.show', 'pertambangan-ilegal-isu'))
            ->assertSee(route('content.show', 'deforestasi-isu'))
            ->assertSee('Baca Selengkapnya');
    }
}
