<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ContentController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/blog', 'blog')->name('blog');

Route::view('/tentang-kami', 'tentang-kami')->name('about');

Route::get('/regulasi', function () {
    $search = request('search');
    $categoryFilter = request('kategori');

    $query = \App\Models\Content::where('category', 'regulasi')
        ->where('status', 'published');

    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('body', 'like', "%{$search}%")
              ->orWhere('tags', 'like', "%{$search}%");
        });
    }

    if ($categoryFilter) {
        // Map slug/param back to database tag format if needed
        $tagMap = [
            'undang-undang' => 'undang-undang',
            'peraturan-pemerintah' => 'peraturan pemerintah',
            'peraturan-daerah' => 'peraturan daerah',
            'keputusan-menteri' => 'keputusan menteri',
            'peraturan-menteri' => 'peraturan menteri',
        ];
        $mappedTag = $tagMap[$categoryFilter] ?? $categoryFilter;
        $query->where('tags', 'like', "%{$mappedTag}%");
    }

    $items = $query->orderBy('publish_date', 'desc')->get();

    // Stats counts based on tags
    $allRegulasi = \App\Models\Content::where('category', 'regulasi')->where('status', 'published')->get();
    
    $countUU = $allRegulasi->filter(fn($item) => str_contains(strtolower($item->tags), 'undang-undang'))->count();
    $countPP = $allRegulasi->filter(fn($item) => str_contains(strtolower($item->tags), 'peraturan pemerintah'))->count();
    $countPD = $allRegulasi->filter(fn($item) => str_contains(strtolower($item->tags), 'peraturan daerah'))->count();
    $countKM = $allRegulasi->filter(fn($item) => str_contains(strtolower($item->tags), 'keputusan menteri') || str_contains(strtolower($item->tags), 'peraturan menteri'))->count();

    return view('regulasi', compact('items', 'countUU', 'countPP', 'countPD', 'countKM', 'search', 'categoryFilter'));
})->name('regulasi');

Route::get('/publikasi/siaran-pers', function () {
    $items = \App\Models\Content::where('category', 'siaran-pers')
        ->where('status', 'published')
        ->orderBy('publish_date', 'desc')
        ->get();

    return view('siaran-pers', compact('items'));
})->name('siaran-pers');

Route::get('/publikasi/infografis', function () {
    $items = \App\Models\Content::where('category', 'infografis')
        ->where('status', 'published')
        ->orderBy('publish_date', 'desc')
        ->get();

    return view('infografis', compact('items'));
})->name('infografis');

Route::get('/publikasi/laporan-tahunan', function () {
    $items = \App\Models\Content::where('category', 'laporan-tahunan')
        ->where('status', 'published')
        ->orderBy('publish_date', 'desc')
        ->get();

    return view('laporan-tahunan', compact('items'));
})->name('laporan-tahunan');

Route::get('/dukung-kami/donasi-publik', function () {
    return view('donasi');
})->name('donasi');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    
    // Group routes for 'tentang' prefix
    Route::prefix('tentang')->group(function () {
        Route::get('/{category}', [ContentController::class, 'index'])->name('content.tentang.index');
        Route::post('/{category}', [ContentController::class, 'store'])->name('content.tentang.store');
        Route::put('/{category}/{content}', [ContentController::class, 'update'])->name('content.tentang.update');
        Route::delete('/{category}/{content}', [ContentController::class, 'destroy'])->name('content.tentang.destroy');
        Route::patch('/{category}/{content}/toggle-status', [ContentController::class, 'toggleStatus'])->name('content.tentang.toggle-status');
    });

    // Root categories
    Route::get('/{category}', [ContentController::class, 'index'])->name('content.index');
    Route::post('/{category}', [ContentController::class, 'store'])->name('content.store');
    Route::put('/{category}/{content}', [ContentController::class, 'update'])->name('content.update');
    Route::delete('/{category}/{content}', [ContentController::class, 'destroy'])->name('content.destroy');
    Route::patch('/{category}/{content}/toggle-status', [ContentController::class, 'toggleStatus'])->name('content.toggle-status');
});
