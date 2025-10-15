<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Milon\Barcode\DNS1D;

Route::get('/login', [AuthController::class, 'index'])->name('login');

Route::get('/', [DashboardController::class, 'view'])->name('dashboard');

// Product Route
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');
Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');



Route::get('/barcode/{code}', function ($code) {
    return Cache::remember("barcode_{$code}", now()->addHours(6), function () use ($code) {
        $barcode = new DNS1D();
        return response($barcode->getBarcodePNG($code, 'C128'))
            ->header('Content-Type', 'image/png');
    });
})->name('barcode.show');


Route::get('/inventory', [DashboardController::class, 'inventory'])->name('inventory');
