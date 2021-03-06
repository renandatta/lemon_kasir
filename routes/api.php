<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LisensiController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\ProfilController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('lisensi', [LisensiController::class, 'search']);

Route::prefix('profil')->group(function () {
    Route::post('info', [ProfilController::class, 'info']);
    Route::post('save', [ProfilController::class, 'save']);
});

Route::prefix('user')->group(function () {
    Route::post('search', [UserController::class, 'search']);
    Route::post('info', [UserController::class, 'info']);
    Route::post('save', [UserController::class, 'save']);
    Route::post('delete', [UserController::class, 'delete']);
});

Route::prefix('produk')->group(function () {
    Route::post('search', [ProdukController::class, 'search']);
    Route::post('info', [ProdukController::class, 'info']);
    Route::post('save', [ProdukController::class, 'save']);
    Route::post('delete', [ProdukController::class, 'delete']);
});
