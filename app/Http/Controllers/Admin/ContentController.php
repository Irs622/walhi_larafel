<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            return view('admin.donasi.index', compact('items', 'config', 'counts', 'category'));
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
            'publish_date' => 'nullable|date',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Handle unique slug
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Content::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
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
            'publish_date' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);

        // Handle unique slug excluding current
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Content::where('slug', $validated['slug'])->where('id', '!=', $content->id)->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        $content->update($validated);

        return redirect()->back()->with('success', 'Konten berhasil diperbarui.');
    }

    public function destroy($category, Content $content)
    {
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
