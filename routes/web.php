<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/blog', 'blog')->name('blog');

Route::view('/tentang-kami', 'tentang-kami')->name('about');

Route::view('/admin', 'admin')->name('admin');
Route::view('/admin/{any?}', 'admin')
    ->where('any', '.*');
