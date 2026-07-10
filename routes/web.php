<?php

use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminSubscriberController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicContentController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

// ============================================================
// PUBLIC ROUTES (No Authentication Required)
// ============================================================

Route::get('/', [PublicContentController::class, 'home'])->name('home');

// Redirect /dashboard → admin dashboard (Breeze compatibility)
Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))
    ->middleware(['auth'])
    ->name('dashboard');

// Blog & Content
Route::get('/blog', [PublicContentController::class, 'blog'])->name('blog');
Route::get('/konten/{slug}', [PublicContentController::class, 'show'])->name('content.show');

// Comments & Newsletter
Route::post('/konten/{content}/komentar', [CommentController::class, 'store'])->name('comments.store');
Route::post('/newsletter/subscribe', [SubscriptionController::class, 'subscribe'])->name('newsletter.subscribe');

// Donation
Route::post('/donasi/pay', [DonationController::class, 'pay'])->name('donasi.pay');
Route::post('/donasi/webhook', [DonationController::class, 'webhook'])->name('donasi.webhook');

// Public Pages (moved from inline closures to PageController)
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/regulasi', [PageController::class, 'regulasi'])->middleware('throttle:search')->name('regulasi');
Route::get('/publikasi/siaran-pers', [PageController::class, 'siaranPers'])->name('siaran-pers');
Route::get('/publikasi/infografis', [PageController::class, 'infografis'])->name('infografis');
Route::get('/publikasi/laporan-tahunan', [PageController::class, 'laporanTahunan'])->name('laporan-tahunan');
Route::get('/dukung-kami/donasi-publik', [PageController::class, 'donasi'])->name('donasi');

// SEO
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [PageController::class, 'robots']);

// ============================================================
// MOCK ROUTES — Local / Testing Environment Only
// ============================================================
// These routes are intentionally excluded from production.
// Never register them unconditionally.
if (app()->environment('local', 'testing')) {
    Route::post('/donasi/mock-payment-status', [DonationController::class, 'mockPaymentStatus'])
        ->name('donasi.mock-payment-status');
}

// ============================================================
// AUTHENTICATED ROUTES (Login Required)
// ============================================================

Route::middleware('auth')->group(function () {
    // Profile management (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ──────────────────────────────────────────────────────────────────────
    // ADMIN ROUTES
    // ──────────────────────────────────────────────────────────────────────
    Route::prefix('admin')->name('admin.')->middleware('throttle:admin-actions')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');

        // "Tentang" sub-prefix (sejarah, visi-misi, dewan-nasional, etc.)
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

        // Comment moderation
        Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
        Route::post('/comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
        Route::post('/comments/{comment}/spam', [AdminCommentController::class, 'spam'])->name('comments.spam');
        Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');

        // Newsletter subscribers
        Route::get('/subscribers', [AdminSubscriberController::class, 'index'])->name('subscribers.index');
        Route::get('/subscribers/export', [AdminSubscriberController::class, 'export'])->name('subscribers.export');
        Route::delete('/subscribers/{subscriber}', [AdminSubscriberController::class, 'destroy'])->name('subscribers.destroy');
    });
});

require __DIR__ . '/auth.php';
