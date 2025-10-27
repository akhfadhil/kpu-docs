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
use Illuminate\Support\Facades\Route;

Route::get("/", [SessionController::class, "index"]);
Route::post("/", [SessionController::class, "login"]);

// Route yang dilindungi middleware
Route::middleware(["check.login"])->group(function () {
    // Admin
    // Dashboard
    Route::get("/admin", [AdminController::class, "index"])
        ->middleware("check.role:admin")
        ->name("admin");

    // Kecamatan
    Route::middleware(["check.role:ppk"])->group(function () {
        // Dashboard
        Route::get("/kecamatan/{id}", [
            KecamatanController::class,
            "index",
        ])->name("kecamatan.index");
        // Add PPK member
        Route::post("/kecamatan/{id}/ppk", [
            PPKMemberController::class,
            "store",
        ])->name("ppk.store");
        // Delete PPK member
        Route::delete("/ppk/{id}", [
            PPKMemberController::class,
            "destroy",
        ])->name("ppk.anggota.destroy");
    });

    // Desa
    Route::middleware(["check.role:pps"])->group(function () {
        // Dashboard
        Route::get("/desa/{desaId}", [DesaController::class, "index"])->name(
            "desa.index",
        );
        // Add PPS member
        Route::post("/desa/{desaId}/pps", [
            PPSMemberController::class,
            "store",
        ])->name("pps.store");
        // Delete KPPS member
        Route::delete("/pps/{id}", [
            PPSMemberController::class,
            "destroy",
        ])->name("pps.anggota.destroy");
    });

    // TPS
    Route::middleware(["check.role:kpps"])->group(function () {
        // Dashboard
        Route::get("/tps/{tpsId}", [TPSController::class, "index"])->name(
            "tps.index",
        );
        // Add KPPS member
        Route::post("/kpps/{tpsId}/anggota", [
            KPPSMemberController::class,
            "store",
        ])->name("kpps.anggota.store");
        // Update data
        Route::put("/kpps/{id}", [KPPSMemberController::class, "update"])->name(
            "kpps.anggota.update",
        );
        // Delete KPPS member
        Route::delete("/kpps/{id}", [
            KPPSMemberController::class,
            "destroy",
        ])->name("kpps.anggota.destroy");
    });

    // Upload
    // Dashboard upload
    Route::get("/upload", [UploadController::class, "index"])->name(
        "upload.index",
    );
    // Add/Upload docs
    Route::post("/upload", [UploadController::class, "store"])->name(
        "upload.store",
    );

    // Logout
    Route::get("/logout", [SessionController::class, "logout"])->name("logout");

    // Else
    Route::get("/get-desa-by-kecamatan/{id}", [
        LocationController::class,
        "getDesaByKecamatan",
    ]);

    // Note:
    // Link breadcrumb
    // Edit anggota
    // add anggota ppk
    // add desa
    // add tps
    // modal modal confirm / error page /
    // toast succes / failed
    // check clean code
});
