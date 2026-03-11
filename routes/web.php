<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard
Route::redirect('/', '/dashboard');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Customers CRUD
    Route::resource('customers', CustomerController::class);

    // Categories CRUD (formerly service-packages)
    Route::resource('categories', CategoryController::class);

    // Products CRUD
    Route::resource('products', ProductController::class);

    // POS Kasir
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos', [PosController::class, 'store'])->name('pos.store');
    Route::get('/pos/receipt/{transaction}', [PosController::class, 'receipt'])->name('pos.receipt');

    // Subscriptions CRUD + Renew
    Route::resource('subscriptions', SubscriptionController::class);
    Route::patch('subscriptions/{subscription}/renew', [SubscriptionController::class, 'renew'])
         ->name('subscriptions.renew');

    // Payments CRUD
    Route::resource('payments', PaymentController::class);

    // Transaction History
    Route::resource('transactions', TransactionController::class)->only(['index', 'show']);
});
