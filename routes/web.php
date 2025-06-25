<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CMSController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerProductController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Publicly accessible homepage with CMS posts or landing page
Route::get('/', function () {
    return view('welcome');
});

// CMS public view page
Route::get('/content/{slug}', [CMSController::class, 'show'])->name('content.show');

// Auth routes (Laravel Breeze)
require __DIR__.'/auth.php';

// Secured routes group
Route::middleware(['auth'])->group(function () {
    // Dashboard or homepage after login
    Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/products', [CustomerProductController::class, 'index'])->name('products.cust.index');
Route::get('/products/{product}', [CustomerProductController::class, 'show'])->name('products.show');

// Admin product management routes (restricted)
Route::middleware(['auth', 'can:manage-products'])->prefix('admin')->group(function () {
    Route::resource('products', ProductController::class)->names('products.manage');
});

    // Orders user can see their own orders, admin can see all
    Route::resource('orders', OrderController::class)->middleware('can:view-orders');

    // CMS admin only
    Route::middleware('can:manage-cms')->group(function() {
        Route::resource('cms', CMSController::class);
    });


     Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});