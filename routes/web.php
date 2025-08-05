<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductsController;

// Halaman utama (redirect ke produk atau tampilkan landing page)
Route::get('/', function () {
    return view('welcome'); // atau redirect('/product');
});

// Dashboard (hanya untuk user terverifikasi)
Route::get('/dashboard', [ProductsController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

// Group untuk user yang sudah login
Route::middleware('auth')->group(function () {
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Produk (CRUD)
    Route::resource('products', ProductsController::class);
});

// Route autentikasi dari Laravel Breeze
require __DIR__.'/auth.php';
