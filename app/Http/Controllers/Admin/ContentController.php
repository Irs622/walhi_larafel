<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    protected $config = [
        'blog' => ['title' => 'Blog', 'desc' => 'Kelola artikel dan tulisan di halaman Blog.'],
        'regulasi' => ['title' => 'Regulasi', 'desc' => 'Kelola dokumen peraturan dan regulasi lingkungan.'],
        'siaran-pers' => ['title' => 'Siaran Pers', 'desc' => 'Kelola siaran pers dan rilis media WALHI Jabar.'],
        'infografis' => ['title' => 'Infografis', 'desc' => 'Kelola infografis dan visualisasi data lingkungan.'],
        'kertas-posisi' => ['title' => 'Kertas Posisi', 'desc' => 'Kelola dokumen posisi kebijakan WALHI Jabar.'],
        'newsletter' => ['title' => 'E-Newsletter', 'desc' => 'Kelola edisi E-Newsletter WALHI Jabar.'],
        'buletin-bumi' => ['title' => 'Buletin Bumi', 'desc' => 'Kelola edisi Buletin Bumi.'],
        'jurnal' => ['title' => 'Jurnal Tanah Air', 'desc' => 'Kelola edisi Jurnal Tanah Air.'],
        'laporan-tahunan' => ['title' => 'Laporan Tahunan', 'desc' => 'Kelola laporan tahunan organisasi.'],
        'sejarah' => ['title' => 'Sejarah', 'desc' => 'Kelola halaman Sejarah organisasi.'],
        'visi-misi' => ['title' => 'Visi & Misi', 'desc' => 'Kelola konten Visi dan Misi.'],
        'dewan-nasional' => ['title' => 'Dewan Nasional', 'desc' => 'Kelola data anggota Dewan Nasional.'],
        'eksekutif-nasional' => ['title' => 'Eksekutif Nasional', 'desc' => 'Kelola data Eksekutif Nasional.'],
        'eksekutif-daerah' => ['title' => 'Eksekutif Daerah', 'desc' => 'Kelola data Eksekutif Daerah.'],
        'kontak' => ['title' => 'Kontak', 'desc' => 'Kelola informasi kontak organisasi.'],
        'donasi' => ['title' => 'Kampanye Donasi', 'desc' => 'Manajemen kampanye donasi dan laporan penerimaan.'],
        'pekan-rakyat' => ['title' => 'Pekan Rakyat', 'desc' => 'Manajemen event Pekan Rakyat.'],
        'statistik' => ['title' => 'Statistik Utama', 'desc' => 'Kelola angka-angka statistik utama di halaman Beranda.'],
        'isu-kritis' => ['title' => 'Isu Kritis', 'desc' => 'Kelola 5 isu kritis lingkungan di halaman Beranda.'],
        'kampanye-darurat' => ['title' => 'Kampanye Darurat', 'desc' => 'Kelola teks & link Kampanye Darurat di bar navigasi atas.'],
    ];

    private function getCategoryConfig($category)
    {
        return $this->config[$category] ?? ['title' => Str::title($category), 'desc' => ''];
    }

    public function index(Request $request, $category)
    {
        $config = $this->getCategoryConfig($category);
        $search = $request->input('search');

        $query = Content::where('category', $category);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        $items = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Calculate counts
        $total = Content::where('category', $category)->count();
        $published = Content::where('category', $category)->where('status', 'published')->count();
        $draft = Content::where('category', $category)->where('status', 'draft')->count();
        $archived = Content::where('category', $category)->where('status', 'archived')->count();

        $counts = compact('total', 'published', 'draft', 'archived');

        // Different view for specific pages (donasi, pekan-rakyat, standard content)
        if ($category === 'donasi') {
            $recentDonations = \App\Models\Donation::orderBy('created_at', 'desc')->take(10)->get();
            $totalAmount = \App\Models\Donation::where('status', 'success')->sum('amount');
            $uniqueDonors = \App\Models\Donation::where('status', 'success')->distinct('donor_email')->count('donor_email');
            $avgDonation = \App\Models\Donation::where('status', 'success')->avg('amount') ?: 0;
 
            // Trend last 12 months
            $chartData = [];
            $chartLabels = [];
            for ($i = 11; $i >= 0; $i--) {
                $month = \Carbon\Carbon::now()->startOfMonth()->subMonths($i);
                $chartLabels[] = $month->translatedFormat("M 'y");
                $sum = \App\Models\Donation::where('status', 'success')
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('amount');
                $chartData[] = (int) $sum;
            }
 
            // Fallback to mock data if no real donations yet
            if (array_sum($chartData) === 0) {
                $chartData = [12500000, 18200000, 14800000, 22000000, 31500000, 19300000, 16700000, 24100000, 27800000, 33200000, 29400000, 38900000];
            }
 
            return view('admin.donasi.index', compact('items', 'config', 'counts', 'category', 'recentDonations', 'totalAmount', 'uniqueDonors', 'avgDonation', 'chartLabels', 'chartData'));
        } elseif ($category === 'pekan-rakyat') {
            return view('admin.pekan-rakyat.index', compact('items', 'config', 'counts', 'category'));
        }

        return view('admin.content.index', compact('items', 'config', 'counts', 'category'));
    }

    public function store(Request $request, $category)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'tags' => 'nullable|string',
            'status' => 'required|in:published,draft,archived',
            'image_url' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,webp,gif,pdf,xls,xlsx,doc,docx|max:10240',
            'is_promoted' => 'nullable|boolean',
            'author' => 'nullable|string|max:255',
        ]);

        $validated['is_promoted'] = $request->boolean('is_promoted');

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Handle unique slug
        $originalSlug = $validated['slug'];
        $matchingSlugs = Content::where('slug', 'like', $originalSlug . '%')
            ->pluck('slug')
            ->toArray();

        if (in_array($originalSlug, $matchingSlugs)) {
            $count = 1;
            while (in_array($originalSlug . '-' . $count, $matchingSlugs)) {
                $count++;
            }
            $validated['slug'] = $originalSlug . '-' . $count;
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        if ($category === 'isu-kritis') {
            $icon = $request->input('isu_icon', 'Icon-4.svg');
            $badge = $request->input('isu_badge', 'Isu');
            $validated['tags'] = $icon . '|' . $badge;
        } elseif ($category === 'regulasi') {
            $regCategory = $request->input('reg_category', 'undang-undang');
            $regIssuer = $request->input('reg_issuer', 'Pemerintah RI');
            $regStatus = $request->input('reg_status', 'berlaku');
            $validated['tags'] = implode(', ', [$regCategory, $regIssuer, $regStatus]);
        }

        $validated['category'] = $category;

        Content::create($validated);

        return redirect()->back()->with('success', 'Konten berhasil ditambahkan.');
    }

    public function update(Request $request, $category, Content $content)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'body' => 'nullable|string',
            'tags' => 'nullable|string',
            'status' => 'required|in:published,draft,archived',
            'image_url' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,webp,gif,pdf,xls,xlsx,doc,docx|max:10240',
            'publish_date' => 'nullable|date',
            'is_promoted' => 'nullable|boolean',
            'author' => 'nullable|string|max:255',
        ]);

        $validated['is_promoted'] = $request->boolean('is_promoted');

        $validated['slug'] = Str::slug($validated['slug']);

        // Handle unique slug excluding current
        $originalSlug = $validated['slug'];
        $matchingSlugs = Content::where('slug', 'like', $originalSlug . '%')
            ->where('id', '!=', $content->id)
            ->pluck('slug')
            ->toArray();

        if (in_array($originalSlug, $matchingSlugs)) {
            $count = 1;
            while (in_array($originalSlug . '-' . $count, $matchingSlugs)) {
                $count++;
            }
            $validated['slug'] = $originalSlug . '-' . $count;
        }

        if ($request->hasFile('image')) {
            // Delete old uploaded image if any
            if ($content->image_url && str_starts_with($content->image_url, '/storage/uploads/')) {
                $oldPath = str_replace('/storage/', '', $content->image_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image')->store('uploads', 'public');
            $validated['image_url'] = '/storage/' . $path;
        } elseif (array_key_exists('image_url', $validated) && $validated['image_url'] !== $content->image_url) {
            // If they manually cleared or changed the URL, delete old uploaded image
            if ($content->image_url && str_starts_with($content->image_url, '/storage/uploads/')) {
                $oldPath = str_replace('/storage/', '', $content->image_url);
                Storage::disk('public')->delete($oldPath);
            }
        }

        if ($category === 'isu-kritis') {
            $icon = $request->input('isu_icon', 'Icon-4.svg');
            $badge = $request->input('isu_badge', 'Isu');
            $validated['tags'] = $icon . '|' . $badge;
        } elseif ($category === 'regulasi') {
            $regCategory = $request->input('reg_category', 'undang-undang');
            $regIssuer = $request->input('reg_issuer', 'Pemerintah RI');
            $regStatus = $request->input('reg_status', 'berlaku');
            $validated['tags'] = implode(', ', [$regCategory, $regIssuer, $regStatus]);
        }

        $content->update($validated);

        return redirect()->back()->with('success', 'Konten berhasil diperbarui.');
    }

    public function destroy($category, Content $content)
    {
        // Delete local uploaded image if any
        if ($content->image_url && str_starts_with($content->image_url, '/storage/uploads/')) {
            $oldPath = str_replace('/storage/', '', $content->image_url);
            Storage::disk('public')->delete($oldPath);
        }
        $content->delete();
        return redirect()->back()->with('success', 'Konten berhasil dihapus.');
    }

    public function toggleStatus($category, Content $content)
    {
        $next = $content->status === 'published' ? 'archived' : 'published';
        $content->update(['status' => $next]);

        return redirect()->back()->with('success', 'Status konten berhasil diubah.');
    }
}
