<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [SessionController::class, 'index']);
Route::post('/', [SessionController::class, 'login']);

Route::get('/admin', [AdminController::class, 'index']);


Route::middleware('auth.custom')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});