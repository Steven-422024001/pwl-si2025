<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\CategoryController;


// Route untuk halaman utama/dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route resource untuk fitur CRUD
Route::resource('products', ProductController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('transaksi', TransaksiController::class);
Route::resource('category', CategoryController::class);

// Root ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

//Route Login regis dll

Route::get('/login', [AuthController::class, 'loginform'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/register', [AuthController::class, 'registerform'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Route yang dilindungi login
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('transaksi', TransaksiController::class);
    //email
    Route::get('/send-email/{to}/{id}', [\App\Http\Controllers\TransaksiController::class, 'sendEmail']);
    Route::resource('category', CategoryController::class);
});

//route logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');