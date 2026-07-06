<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\PublicContentController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\AdminSubscriberController;

// ============================================================
// PUBLIC ROUTES (No Authentication Required)
// ============================================================

Route::get('/', [PublicContentController::class, 'home'])->name('home');

// Redirect /dashboard to admin (Breeze compatibility)
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/blog', [PublicContentController::class, 'blog'])->name('blog');
Route::get('/konten/{slug}', [PublicContentController::class, 'show'])->name('content.show');
Route::post('/konten/{content}/komentar', [CommentController::class, 'store'])->name('comments.store');
Route::post('/newsletter/subscribe', [SubscriptionController::class, 'subscribe'])->name('newsletter.subscribe');
 
Route::get('/sitemap.xml', function() {
    $contents = \App\Models\Content::select('slug', 'updated_at')
        ->where('status', 'published')
        ->orderBy('updated_at', 'desc')
        ->get();
    return response()->view('sitemap', compact('contents'))
        ->header('Content-Type', 'text/xml');
})->name('sitemap');
 
Route::get('/robots.txt', function() {
    $path = public_path('robots.txt');
    if (file_exists($path)) {
        return response(file_get_contents($path), 200)->header('Content-Type', 'text/plain');
    }
    return response("User-agent: *\nDisallow:", 200)->header('Content-Type', 'text/plain');
});

Route::post('/donasi/pay', [DonationController::class, 'pay'])->name('donasi.pay');
Route::post('/donasi/webhook', [DonationController::class, 'webhook'])->name('donasi.webhook');
Route::post('/donasi/mock-payment-status', [DonationController::class, 'mockPaymentStatus'])->name('donasi.mock-payment-status');

Route::get('/tentang-kami', function () {
    $visiMisi = \App\Models\Content::where('category', 'visi-misi')
        ->where('status', 'published')
        ->first();
    return view('tentang-kami', compact('visiMisi'));
})->name('about');

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

    $items = $query->orderBy('publish_date', 'desc')->paginate(10)->withQueryString();

    // Stats counts directly from database query
    $countUU = \App\Models\Content::where('category', 'regulasi')
        ->where('status', 'published')
        ->where('tags', 'like', '%undang-undang%')
        ->count();

    $countPP = \App\Models\Content::where('category', 'regulasi')
        ->where('status', 'published')
        ->where('tags', 'like', '%peraturan pemerintah%')
        ->count();

    $countPD = \App\Models\Content::where('category', 'regulasi')
        ->where('status', 'published')
        ->where('tags', 'like', '%peraturan daerah%')
        ->count();

    $countKM = \App\Models\Content::where('category', 'regulasi')
        ->where('status', 'published')
        ->where(function($q) {
            $q->where('tags', 'like', '%keputusan menteri%')
              ->orWhere('tags', 'like', '%peraturan menteri%');
        })
        ->count();

    return view('regulasi', compact('items', 'countUU', 'countPP', 'countPD', 'countKM', 'search', 'categoryFilter'));
})->middleware('throttle:search')->name('regulasi');

Route::get('/publikasi/siaran-pers', function () {
    $items = \App\Models\Content::where('category', 'siaran-pers')
        ->where('status', 'published')
        ->orderBy('publish_date', 'desc')
        ->paginate(9)
        ->withQueryString();

    return view('siaran-pers', compact('items'));
})->name('siaran-pers');

Route::get('/publikasi/infografis', function () {
    $items = \App\Models\Content::where('category', 'infografis')
        ->where('status', 'published')
        ->orderBy('publish_date', 'desc')
        ->paginate(9)
        ->withQueryString();

    return view('infografis', compact('items'));
})->name('infografis');

Route::get('/publikasi/laporan-tahunan', function () {
    $items = \App\Models\Content::where('category', 'laporan-tahunan')
        ->where('status', 'published')
        ->orderBy('publish_date', 'desc')
        ->paginate(5)
        ->withQueryString();

    return view('laporan-tahunan', compact('items'));
})->name('laporan-tahunan');

Route::get('/dukung-kami/donasi-publik', function () {
    return view('donasi');
})->name('donasi');

// ============================================================
// AUTHENTICATED ROUTES (Login Required)
// ============================================================

Route::middleware('auth')->group(function () {
    // Profile management (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ============================================================
    // ADMIN ROUTES (Protected by Authentication)
    // ============================================================
    Route::prefix('admin')->name('admin.')->middleware('throttle:admin-actions')->group(function () {
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

        // Comments Moderation
        Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
        Route::post('/comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
        Route::post('/comments/{comment}/spam', [AdminCommentController::class, 'spam'])->name('comments.spam');
        Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');

        // Newsletter Subscribers
        Route::get('/subscribers', [AdminSubscriberController::class, 'index'])->name('subscribers.index');
        Route::get('/subscribers/export', [AdminSubscriberController::class, 'export'])->name('subscribers.export');
        Route::delete('/subscribers/{subscriber}', [AdminSubscriberController::class, 'destroy'])->name('subscribers.destroy');
    });
});

require __DIR__.'/auth.php';
