<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\DashboardController;
use App\Http\Controllers\Kasir\DashboardKasirController;
use App\Http\Controllers\Kasir\PengaturanKasirController;
use App\Http\Controllers\Master\LisensiController;
use App\Http\Controllers\Master\LisensiProfilController;
use App\Http\Controllers\Master\ProfilController;
use App\Http\Controllers\Master\UserProfilController;
use App\Http\Controllers\Pengaturan\FiturProgramController;
use App\Http\Controllers\Pengaturan\UserController;
use App\Http\Controllers\Pengaturan\UserLevelController;
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
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login_proses'])->name('login.proses');
    Route::post('register', [AuthController::class, 'register_proses'])->name('register.proses');
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

    Route::prefix('fitur_program')->group(function () {
        Route::get('/', [FiturProgramController::class, 'index'])->name('pengaturan.fitur_program');
        Route::post('info', [FiturProgramController::class, 'info'])->name('pengaturan.fitur_program.info');
        Route::post('search', [FiturProgramController::class, 'search'])->name('pengaturan.fitur_program.search');
        Route::post('save', [FiturProgramController::class, 'save'])->name('pengaturan.fitur_program.save');
        Route::post('delete', [FiturProgramController::class, 'delete'])->name('pengaturan.fitur_program.delete');
        Route::post('kode_otomatis', [FiturProgramController::class, 'kode_otomatis'])->name('pengaturan.fitur_program.kode_otomatis');
        Route::post('reposisi', [FiturProgramController::class, 'reposisi'])->name('pengaturan.fitur_program.reposisi');
    });

});

Route::prefix('master')->group(function () {

    Route::prefix('lisensi')->group(function () {
        Route::get('/', [LisensiController::class, 'index'])->name('master.lisensi');
        Route::get('info', [LisensiController::class, 'info'])->name('master.lisensi.info');
        Route::post('search', [LisensiController::class, 'search'])->name('master.lisensi.search');
        Route::post('save', [LisensiController::class, 'save'])->name('master.lisensi.save');
        Route::post('delete', [LisensiController::class, 'delete'])->name('master.lisensi.delete');
    });

    Route::prefix('profil')->group(function () {
        Route::get('/', [ProfilController::class, 'index'])->name('master.profil');
        Route::get('info', [ProfilController::class, 'info'])->name('master.profil.info');
        Route::post('search', [ProfilController::class, 'search'])->name('master.profil.search');
        Route::post('save', [ProfilController::class, 'save'])->name('master.profil.save');
        Route::post('delete', [ProfilController::class, 'delete'])->name('master.profil.delete');

        Route::prefix('{profil}/user')->group(function () {
            Route::get('/', [UserProfilController::class, 'index'])->name('master.profil.user');
            Route::get('info', [UserProfilController::class, 'info'])->name('master.profil.user.info');
            Route::post('search', [UserProfilController::class, 'search'])->name('master.profil.user.search');
            Route::post('save', [UserProfilController::class, 'save'])->name('master.profil.user.save');
            Route::post('delete', [UserProfilController::class, 'delete'])->name('master.profil.user.delete');
        });

        Route::prefix('{profil}/lisensi')->group(function () {
            Route::get('/', [LisensiProfilController::class, 'index'])->name('master.profil.lisensi');
            Route::get('info', [LisensiProfilController::class, 'info'])->name('master.profil.lisensi.info');
            Route::post('search', [LisensiProfilController::class, 'search'])->name('master.profil.lisensi.search');
            Route::post('save', [LisensiProfilController::class, 'save'])->name('master.profil.lisensi.save');
            Route::post('delete', [LisensiProfilController::class, 'delete'])->name('master.profil.lisensi.delete');
        });
    });

});

Route::prefix('kasir')->group(function () {
    Route::get('dashboard', [DashboardKasirController::class, 'index'])->name('kasir.dashboard');

    Route::prefix('pengaturan')->group(function () {
        Route::get('/', [PengaturanKasirController::class, 'index'])->name('kasir.pengaturan');
        Route::get('edit', [PengaturanKasirController::class, 'edit'])->name('kasir.pengaturan.edit');
        Route::post('save', [PengaturanKasirController::class, 'save'])->name('kasir.pengaturan.save');
    });
});
