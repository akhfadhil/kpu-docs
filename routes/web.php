<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [SessionController::class, 'index']);
Route::post('/', [SessionController::class, 'login']);

// Route yang dilindungi middleware
Route::middleware(['check.login'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->middleware('check.role:admin')->name('admin');    
    Route::get('/ppk', [AdminController::class, 'index'])->middleware('check.role:ppk')->name('ppk');
    Route::get('/pps', [AdminController::class, 'index'])->middleware('check.role:pps')->name('pps');
    Route::get('/kpps', [AdminController::class, 'index'])->middleware('check.role:kpps')->name('kpps');
    
    Route::get('/logout', [SessionController::class, 'logout'])->name('logout');
});
