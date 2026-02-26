<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/{slug}', [ProductController::class, 'show'])->name('show');
    Route::post('/{product}/review', [ProductController::class, 'review'])->name('review')->middleware('auth');
});

// Cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::delete('/remove/{productId}', [CartController::class, 'remove'])->name('remove');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

// Checkout (auth required)
Route::prefix('checkout')->name('checkout.')->middleware('auth')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
    Route::get('/confirmation/{orderNumber}', [CheckoutController::class, 'confirmation'])->name('confirmation');
});

// User Dashboard (auth required)
Route::prefix('dashboard')->name('user.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [UserDashboardController::class, 'orders'])->name('orders');
    Route::get('/orders/{orderNumber}', [UserDashboardController::class, 'orderDetail'])->name('order-detail');
    Route::get('/settings', [UserDashboardController::class, 'settings'])->name('settings');
    Route::put('/settings', [UserDashboardController::class, 'updateSettings'])->name('settings.update');
    Route::put('/settings/password', [UserDashboardController::class, 'updatePassword'])->name('settings.password');
});

// Admin Panel
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', Admin\ProductController::class);

    // Categories
    Route::resource('categories', Admin\CategoryController::class);

    // Orders
    Route::get('/orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('orders.status');

    // Users
    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [Admin\UserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/toggle-admin', [Admin\UserController::class, 'toggleAdmin'])->name('users.toggle-admin');
});

// Auth Routes
require __DIR__ . '/auth.php';
