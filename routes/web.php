<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServicePackageController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard
Route::redirect('/', '/dashboard');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Customers CRUD
Route::resource('customers', CustomerController::class);

// Service Packages CRUD
Route::resource('service-packages', ServicePackageController::class);

// Subscriptions CRUD + Renew
Route::resource('subscriptions', SubscriptionController::class);
Route::patch('subscriptions/{subscription}/renew', [SubscriptionController::class, 'renew'])
     ->name('subscriptions.renew');

// Payments CRUD
Route::resource('payments', PaymentController::class);
