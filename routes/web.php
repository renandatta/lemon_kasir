<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\DashboardController;
use App\Http\Controllers\Program\UserController;
use App\Http\Controllers\Program\UserLevelController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('image/{folder}/{filename}', function ($folder,$filename){
    $path = storage_path('app/' . $folder . '/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::prefix('auth')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('login', [AuthController::class, 'login_proses'])->name('login.proses');
});

Route::prefix('home')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('home.dashboard');
});

Route::prefix('pengaturan')->group(function () {

    Route::prefix('user_level')->group(function () {
        Route::get('/', [UserLevelController::class, 'index'])->name('pengaturan.user_level');
        Route::get('info', [UserLevelController::class, 'info'])->name('pengaturan.user_level.info');
        Route::post('search', [UserLevelController::class, 'search'])->name('pengaturan.user_level.search');
        Route::post('save', [UserLevelController::class, 'save'])->name('pengaturan.user_level.save');
        Route::post('delete', [UserLevelController::class, 'delete'])->name('pengaturan.user_level.delete');

        Route::prefix('hak_akses')->group(function () {
            Route::get('/', [UserLevelController::class, 'hak_akses'])->name('pengaturan.user_level.hak_akses');
            Route::post('save', [UserLevelController::class, 'hak_akses_save'])->name('pengaturan.user_level.hak_akses.save');
        });
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('pengaturan.user');
        Route::get('info', [UserController::class, 'info'])->name('pengaturan.user.info');
        Route::post('search', [UserController::class, 'search'])->name('pengaturan.user.search');
        Route::post('save', [UserController::class, 'save'])->name('pengaturan.user.save');
        Route::post('delete', [UserController::class, 'delete'])->name('pengaturan.user.delete');
    });

});
