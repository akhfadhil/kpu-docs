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
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForcePasswordController;
use Illuminate\Support\Facades\Route;

Route::get("/", [SessionController::class, "index"])->name("login");
Route::post("/", [SessionController::class, "login"]);

Route::get("/force-change-password", [
    ForcePasswordController::class,
    "showForm",
])->name("password.force_change");
Route::post("/force-change-password", [
    ForcePasswordController::class,
    "update",
])->name("password.force_change.update");

// Route yang dilindungi middleware
Route::middleware(["check.login"])->group(function () {
    // Admin
    // Dashboard
    Route::get("/admin", [AdminController::class, "index"])
        ->middleware("check.role:admin")
        ->name("admin");
    Route::put("/users/{id}", [UserController::class, "update"])->name(
        "users.update",
    );

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
        // Update data
        Route::put("/ppk/{id}", [PPKMemberController::class, "update"])->name(
            "ppk.anggota.update",
        );
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
        // Update data
        Route::put("/pps/{id}", [PPSMemberController::class, "update"])->name(
            "pps.anggota.update",
        );
        // Delete PPS member
        Route::delete("/pps/{id}", [
            PPSMemberController::class,
            "destroy",
        ])->name("pps.anggota.destroy");

        // Add TPS
        Route::post("/desa/{desa}/tps", [TPSController::class, "store"])->name(
            "desa.tps.store",
        );
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
    // add pengumuman
    // modal modal confirm / error page /
    // toast succes / failed
    // check clean code
    // fix upload nama dokumen tiap role dan nama folder
    // fix form add tps (username dan pass)
    // add download daftar user
    // fix jabatan ppk1 pps1 kpps1
    // fix form number of voters
});
