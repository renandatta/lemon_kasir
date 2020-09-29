<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LisensiController;
use App\Http\Controllers\Api\ProfilController;
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
