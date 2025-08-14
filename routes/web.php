<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SaleController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (menampilkan produk dalam card)
Route::get('/dashboard', [ProductsController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');

// Group untuk user yang sudah login
Route::middleware('auth')->group(function () {
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Produk (CRUD)
    Route::resource('products', ProductsController::class);
    
    Route::prefix('sales')->group(function() {
        Route::get('/select-products', [SaleController::class, 'selectProducts'])->name('sales.select-products');
        Route::get('/create', [SaleController::class, 'create'])->name('sales.create');
        Route::post('/', [SaleController::class, 'store'])->name('sales.store');
        Route::get('/receipt/{id}', [SaleController::class, 'receipt'])->name('sales.receipt');
        Route::get('/', [SaleController::class, 'index'])->name('sales.index');
        Route::delete('/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');
    });
});

require __DIR__.'/auth.php';