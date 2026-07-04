<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ContentController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/blog', 'blog')->name('blog');

Route::view('/tentang-kami', 'tentang-kami')->name('about');

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
