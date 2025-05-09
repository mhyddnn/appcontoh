<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('products', function () {
        return Inertia::render('product');
    })->name('products');
});


Route::get('/api/products', [ProductController::class, 'index']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
