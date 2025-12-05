<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Milon\Barcode\DNS1D;

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Product Route
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');
Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

// Category Route
Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/{id}', [CategoryController::class, 'detail'])->name('category.detail');
Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');

//Stock Adjustments Route
Route::get('/stock-adjustment', [StockAdjustmentController::class, 'index'])->name('stock-adjustment.index');
Route::get('/stock-adjustment/create', [StockAdjustmentController::class, 'create'])->name('stock-adjustment.create');
Route::post('/stock-adjustment/store', [StockAdjustmentController::class, 'store'])->name('stock-adjustment.store');

//Stock Movements Route
Route::get('/stock-movement', [StockMovementController::class, 'index'])->name('stock-movement.index');

// Stock Route
Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
Route::get('/stock/create', [StockController::class, 'create'])->name('stock.create');

// Supplier Route
Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
Route::get('/supplier/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
Route::put('/supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
Route::delete('/supplier/delete/{id}', [SupplierController::class, 'destroy'])->name('supplier.delete');

// Customer Route
Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
Route::get('/customer/{id}', [CustomerController::class, 'show'])->name('customer.show');
Route::get('/customer/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
Route::put('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
Route::delete('/customer/delete/{id}', [CustomerController::class, 'destroy'])->name('customer.delete');


Route::get('/barcode/{code}', function ($code) {
    return Cache::remember("barcode_{$code}", now()->addHours(6), function () use ($code) {
        $barcode = new DNS1D();
        return response($barcode->getBarcodePNG($code, 'C128'))
            ->header('Content-Type', 'image/png');
    });
})->name('barcode.show');

Route::get('/stock/get-qty/{product_id}', function ($id) {
    $stock = \App\Models\Stock::where('product_id', $id)->first();
    return response()->json(['qty' => $stock->qty_on_hand ?? 0]);
});


Route::get('/inventory', [DashboardController::class, 'inventory'])->name('inventory');
