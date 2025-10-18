<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\TPSController;
use App\Http\Controllers\KPPSAnggotaController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;


Route::get('/', [SessionController::class, 'index']);
Route::post('/', [SessionController::class, 'login']);

// Route yang dilindungi middleware
Route::middleware(['check.login'])->group(function () {

    // Admin
    Route::get('/admin', [AdminController::class, 'index'])
        ->middleware('check.role:admin')
        ->name('admin');    

    // Kecamatan
    Route::get('/kecamatan/{id}', [KecamatanController::class, 'index'])
        ->middleware('check.role:ppk')
        ->name('kecamatan.index');

    // Desa
    Route::get('/desa/{desaId}', [DesaController::class, 'index'])
        ->middleware('check.role:pps')
        ->name('desa.index');

    // TPS
    Route::middleware(['check.role:kpps'])->group(function () {
        Route::get('/tps/{tpsId}', [TPSController::class, 'index'])
            ->name('tps.index');
        Route::post('/tps/{tpsId}/anggota', [KPPSAnggotaController::class, 'store'])
            ->name('kpps.anggota.store');
        Route::get('/upload', [UploadController::class, 'index'])->name('upload.index');
        Route::post('/upload', [UploadController::class, 'store'])->name('upload.store');

    });

    // Logout
    Route::get('/logout', [SessionController::class, 'logout'])->name('logout');

    // Else
    Route::get('/get-desa-by-kecamatan/{id}', [LocationController::class, 'getDesaByKecamatan']);
});

