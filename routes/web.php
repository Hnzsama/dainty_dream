<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\IncomingTransactionController;
use App\Http\Controllers\OutgoingTransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Middleware\EnsureUserIsAuthenticated;

// Redirect root
Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
})->name('home');

// Auth
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware([EnsureUserIsAuthenticated::class])->group(function () {
    // Route to dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    Route::resource('products', ProductController::class)->except('show');
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('suppliers', SupplierController::class)->except('show');
    Route::resource('customers', CustomerController::class)->except('show');
    Route::resource('incoming', IncomingTransactionController::class)->except('show');
    Route::resource('outgoing', OutgoingTransactionController::class)->except('show');
    Route::resource('users', UserController::class)->except('show');
    
    // Report Routes
    Route::get('/reports/monthly', [ReportController::class, 'monthlyReport'])->name('reports.monthly');
});
