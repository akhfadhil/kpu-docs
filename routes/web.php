<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\TPSController;
use App\Http\Controllers\KPPSMemberController;
use App\Http\Controllers\PPSMemberController;
use App\Http\Controllers\PPKMemberController;
use App\Http\Controllers\UploadController;
use App\Models\PPSMember;
use Illuminate\Support\Facades\Route;

Route::get("/", [SessionController::class, "index"]);
Route::post("/", [SessionController::class, "login"]);

// Route yang dilindungi middleware
Route::middleware(["check.login"])->group(function () {
    // Admin
    Route::get("/admin", [AdminController::class, "index"])
        ->middleware("check.role:admin")
        ->name("admin");

    // Kecamatan
    Route::middleware(["check.role:pps"])->group(function () {
        Route::get("/kecamatan/{id}", [
            KecamatanController::class,
            "index",
        ])->name("kecamatan.index");
        Route::post("/kecamatan/{id}/ppk", [
            PPKMemberController::class,
            "store",
        ])->name("ppk.store");
    });

    // Desa
    Route::middleware(["check.role:pps"])->group(function () {
        // Route::get('/desa/{desaId}/tps/create', [TPSController::class, 'create'])
        //     ->name('tps.create');
        // Route::post('/desa/{desaId}/tps', [TPSController::class, 'store'])
        //     ->name('tps.store');
        Route::get("/desa/{desaId}", [DesaController::class, "index"])->name(
            "desa.index",
        );
        Route::post("/desa/{desaId}/pps", [
            PPSMemberController::class,
            "store",
        ])->name("pps.store");
    });

    // TPS
    Route::middleware(["check.role:kpps"])->group(function () {
        Route::get("/tps/{tpsId}", [TPSController::class, "index"])->name(
            "tps.index",
        );
        Route::post("/tps/{tpsId}/anggota", [
            KPPSMemberController::class,
            "store",
        ])->name("kpps.anggota.store");
        Route::get("/upload", [UploadController::class, "index"])->name(
            "upload.index",
        );
        Route::post("/upload", [UploadController::class, "store"])->name(
            "upload.store",
        );
    });

    // Logout
    Route::get("/logout", [SessionController::class, "logout"])->name("logout");

    // Else
    Route::get("/get-desa-by-kecamatan/{id}", [
        LocationController::class,
        "getDesaByKecamatan",
    ]);
});
