<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::get('/lihat', [ProductController::class, 'lihat']);
    Route::get('/lihat/{id}', [ProductController::class, 'lihat_by_id']);
});
Route::prefix('suppliers')->group(function () {
    Route::get('/lihat', [SupplierController::class, 'lihat']);
    Route::get('/lihat/{id}', [SupplierController::class, 'lihat_by_id']);
});

Route::apiResource('users', UserController::class );
Route::post('login ', [UserController::class, 'login']);

Route::get('test', function(){
    return response()->json(['message' => 'API is working!']);
});   
