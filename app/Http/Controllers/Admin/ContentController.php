<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreContentRequest;
use App\Http\Requests\Admin\UpdateContentRequest;
use App\Models\Content;
use App\Models\Donation;
use App\Services\Content\SlugService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function __construct(private readonly SlugService $slugService) {}

    /**
     * Map of category slugs to display titles and descriptions.
     * Used to drive the Admin UI labels.
     */
    protected array $config = [
        'blog'               => ['title' => 'Blog',              'desc' => 'Kelola artikel dan tulisan di halaman Blog.'],
        'regulasi'           => ['title' => 'Regulasi',           'desc' => 'Kelola dokumen peraturan dan regulasi lingkungan.'],
        'siaran-pers'        => ['title' => 'Siaran Pers',        'desc' => 'Kelola siaran pers dan rilis media WALHI Jabar.'],
        'infografis'         => ['title' => 'Infografis',         'desc' => 'Kelola infografis dan visualisasi data lingkungan.'],
        'kertas-posisi'      => ['title' => 'Kertas Posisi',      'desc' => 'Kelola dokumen posisi kebijakan WALHI Jabar.'],
        'newsletter'         => ['title' => 'E-Newsletter',       'desc' => 'Kelola edisi E-Newsletter WALHI Jabar.'],
        'buletin-bumi'       => ['title' => 'Buletin Bumi',       'desc' => 'Kelola edisi Buletin Bumi.'],
        'jurnal'             => ['title' => 'Jurnal Tanah Air',   'desc' => 'Kelola edisi Jurnal Tanah Air.'],
        'laporan-tahunan'    => ['title' => 'Laporan Tahunan',    'desc' => 'Kelola laporan tahunan organisasi.'],
        'sejarah'            => ['title' => 'Sejarah',            'desc' => 'Kelola halaman Sejarah organisasi.'],
        'visi-misi'          => ['title' => 'Visi & Misi',        'desc' => 'Kelola konten Visi dan Misi.'],
        'dewan-nasional'     => ['title' => 'Dewan Nasional',     'desc' => 'Kelola data anggota Dewan Nasional.'],
        'eksekutif-nasional' => ['title' => 'Eksekutif Nasional', 'desc' => 'Kelola data Eksekutif Nasional.'],
        'eksekutif-daerah'   => ['title' => 'Eksekutif Daerah',  'desc' => 'Kelola data Eksekutif Daerah.'],
        'kontak'             => ['title' => 'Kontak',             'desc' => 'Kelola informasi kontak organisasi.'],
        'donasi'             => ['title' => 'Kampanye Donasi',    'desc' => 'Manajemen kampanye donasi dan laporan penerimaan.'],
        'pekan-rakyat'       => ['title' => 'Pekan Rakyat',       'desc' => 'Manajemen event Pekan Rakyat.'],
        'statistik'          => ['title' => 'Statistik Utama',    'desc' => 'Kelola angka-angka statistik utama di halaman Beranda.'],
        'isu-kritis'         => ['title' => 'Isu Kritis',         'desc' => 'Kelola 5 isu kritis lingkungan di halaman Beranda.'],
        'kampanye-darurat'   => ['title' => 'Kampanye Darurat',   'desc' => 'Kelola teks & link Kampanye Darurat di bar navigasi atas.'],
    ];

    private function getCategoryConfig(string $category): array
    {
        return $this->config[$category] ?? ['title' => Str::title($category), 'desc' => ''];
    }

    // ──────────────────────────────────────────────────────────────────────────

    public function index(Request $request, string $category)
    {
        $config = $this->getCategoryConfig($category);
        $search = $request->input('search');

        $query = Content::where('category', $category);

        if ($search) {
            $escapedSearch = str_replace(['%', '_'], ['\%', '\_'], $search);
            $query->where(function ($q) use ($escapedSearch) {
                $q->where('title', 'like', "%{$escapedSearch}%")
                  ->orWhere('tags', 'like', "%{$escapedSearch}%");
            });
        }

        $items = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Status counts (consolidated into a single query via conditional aggregation)
        $rawCounts = Content::where('category', $category)
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published,
                SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as draft,
                SUM(CASE WHEN status = 'archived' THEN 1 ELSE 0 END) as archived
            ")
            ->first();

        $counts = [
            'total'     => (int) ($rawCounts->total ?? 0),
            'published' => (int) ($rawCounts->published ?? 0),
            'draft'     => (int) ($rawCounts->draft ?? 0),
            'archived'  => (int) ($rawCounts->archived ?? 0),
        ];

        // Donation-specific dashboard
        if ($category === 'donasi') {
            $recentDonations = Donation::orderBy('created_at', 'desc')->take(10)->get();
            $totalAmount     = Donation::where('status', 'success')->sum('amount');
            $uniqueDonors    = Donation::where('status', 'success')->distinct('donor_email')->count('donor_email');
            $avgDonation     = Donation::where('status', 'success')->avg('amount') ?: 0;

            // Monthly trend — last 12 months (real data only)
            [$chartLabels, $chartData] = $this->buildMonthlyChart();

            return view('admin.donasi.index', compact(
                'items', 'config', 'counts', 'category',
                'recentDonations', 'totalAmount', 'uniqueDonors', 'avgDonation',
                'chartLabels', 'chartData'
            ));
        }

        if ($category === 'pekan-rakyat') {
            return view('admin.pekan-rakyat.index', compact('items', 'config', 'counts', 'category'));
        }

        return view('admin.content.index', compact('items', 'config', 'counts', 'category'));
    }

    // ──────────────────────────────────────────────────────────────────────────

    public function store(StoreContentRequest $request, string $category)
    {
        $validated = $request->validated();
        $validated['is_promoted'] = $request->boolean('is_promoted');

        // Slug
        $rawSlug = ! empty($validated['slug']) ? $validated['slug'] : $validated['title'];
        $validated['slug'] = $this->slugService->makeUnique(Str::slug($rawSlug));

        // Image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        // Category-specific tag encoding
        $validated['tags'] = $this->encodeTags($request, $category, $validated['tags'] ?? null);
        $validated['category'] = $category;

        Content::create($validated);

        return redirect()->back()->with('success', 'Konten berhasil ditambahkan.');
    }

    // ──────────────────────────────────────────────────────────────────────────

    public function update(UpdateContentRequest $request, string $category, Content $content)
    {
        $validated = $request->validated();
        $validated['is_promoted'] = $request->boolean('is_promoted');

        // Slug (unique, excluding current record)
        $validated['slug'] = $this->slugService->makeUnique(
            Str::slug($validated['slug']),
            $content->id
        );

        // Image upload / removal
        if ($request->hasFile('image')) {
            $this->deleteOldImage($content);
            $path = $request->file('image')->store('uploads', 'public');
            $validated['image_url'] = '/storage/' . $path;
        } elseif (
            array_key_exists('image_url', $validated) &&
            $validated['image_url'] !== $content->image_url
        ) {
            $this->deleteOldImage($content);
        }

        // Category-specific tag encoding
        $validated['tags'] = $this->encodeTags($request, $category, $validated['tags'] ?? null);

        $content->update($validated);

        return redirect()->back()->with('success', 'Konten berhasil diperbarui.');
    }

    // ──────────────────────────────────────────────────────────────────────────

    public function destroy(string $category, Content $content)
    {
        $this->deleteOldImage($content);
        $content->delete(); // SoftDeletes — record still in DB, deleted_at is set

        return redirect()->back()->with('success', 'Konten berhasil dihapus.');
    }

    // ──────────────────────────────────────────────────────────────────────────

    public function toggleStatus(string $category, Content $content)
    {
        $next = $content->status === 'published' ? 'archived' : 'published';
        $content->update(['status' => $next]);

        return redirect()->back()->with('success', 'Status konten berhasil diubah.');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Private Helpers
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Build monthly donation chart data (real data only — no mock fallback).
     * Returns [$labels, $data] for the last 12 months.
     *
     * @return array{0: array<string>, 1: array<int>}
     */
    private function buildMonthlyChart(): array
    {
        $labels = [];
        $data   = [];

        for ($i = 11; $i >= 0; $i--) {
            $month    = Carbon::now()->startOfMonth()->subMonths($i);
            $labels[] = $month->translatedFormat("M 'y");
            $data[]   = (int) Donation::where('status', 'success')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');
        }

        return [$labels, $data];
    }

    /**
     * Encode category-specific tags from the request.
     */
    private function encodeTags(Request $request, string $category, ?string $defaultTags): ?string
    {
        if ($category === 'isu-kritis') {
            $icon  = $request->input('isu_icon', 'Icon-4.svg');
            $badge = $request->input('isu_badge', 'Isu');
            return $icon . '|' . $badge;
        }

        if ($category === 'regulasi') {
            $regCategory = $request->input('reg_category', 'undang-undang');
            $regIssuer   = $request->input('reg_issuer', 'Pemerintah RI');
            $regStatus   = $request->input('reg_status', 'berlaku');
            return implode(', ', [$regCategory, $regIssuer, $regStatus]);
        }

        return $defaultTags;
    }

    /**
     * Delete a locally uploaded image file if it exists.
     */
    private function deleteOldImage(Content $content): void
    {
        if ($content->image_url && str_starts_with($content->image_url, '/storage/uploads/')) {
            $oldPath = str_replace('/storage/', '', $content->image_url);
            Storage::disk('public')->delete($oldPath);
        }
    }
}
