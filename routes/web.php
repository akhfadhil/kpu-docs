<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\DesaController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [SessionController::class, 'index']);
Route::post('/', [SessionController::class, 'login']);

// Route yang dilindungi middleware
Route::middleware(['check.login'])->group(function () {
    // Admin
    Route::get('/admin', [AdminController::class, 'index'])->middleware('check.role:admin')->name('admin');    

    // Kecamatan
    Route::get('/kecamatan/{id}', [KecamatanController::class, 'index'])
        ->middleware('check.role:ppk')
        ->name('kecamatan.index');

    // Desa
    Route::get('/desa/{desaId}', [DesaController::class, 'index'])
        ->middleware('check.role:pps')
        ->name('desa.index');


    Route::get('/pps', [AdminController::class, 'index'])->middleware('check.role:pps')->name('pps');
    Route::get('/kpps', [AdminController::class, 'index'])->middleware('check.role:kpps')->name('kpps');

    // Logout
    Route::get('/logout', [SessionController::class, 'logout'])->name('logout');
});

Route::get('/get-desa-by-kecamatan/{id}', [LocationController::class, 'getDesaByKecamatan']);

