<?php

use Illuminate\Support\Facades\Route;
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
use App\Http\Controllers\AnnouncementController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| Protected Routes (Requires Authentication)
|--------------------------------------------------------------------------
*/
Route::middleware(["check.login"])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(["check.role:admin"])->group(function () {
        // Dashboard
        Route::get("/admin", [AdminController::class, "index"])->name("admin");

        // User management
        Route::put("/users/{id}", [UserController::class, "update"])->name(
            "users.update",
        );
        Route::get("/users/download/pdf", [
            UserController::class,
            "downloadPdf",
        ])->name("users.download.pdf");

        // Announcements
        Route::post("/admin/announcements/store", [
            AnnouncementController::class,
            "store",
        ])->name("admin.announcements.store");
    });

    /*
    |--------------------------------------------------------------------------
    | Kecamatan (PPK) Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(["check.role:ppk"])->group(function () {
        Route::get("/kecamatan/{id}", [
            KecamatanController::class,
            "index",
        ])->name("kecamatan.index");

        // Anggota PPK
        Route::post("/kecamatan/{id}/ppk", [
            PPKMemberController::class,
            "store",
        ])->name("ppk.store");
        Route::put("/ppk/{id}", [PPKMemberController::class, "update"])->name(
            "ppk.anggota.update",
        );
        Route::delete("/ppk/{id}", [
            PPKMemberController::class,
            "destroy",
        ])->name("ppk.anggota.destroy");
    });

    /*
    |--------------------------------------------------------------------------
    | Desa (PPS) Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(["check.role:pps"])->group(function () {
        Route::get("/desa/{desaId}", [DesaController::class, "index"])->name(
            "desa.index",
        );

        // Anggota PPS
        Route::post("/desa/{desaId}/pps", [
            PPSMemberController::class,
            "store",
        ])->name("pps.store");
        Route::put("/pps/{id}", [PPSMemberController::class, "update"])->name(
            "pps.anggota.update",
        );
        Route::delete("/pps/{id}", [
            PPSMemberController::class,
            "destroy",
        ])->name("pps.anggota.destroy");

        // TPS
        Route::post("/desa/{desa}/tps", [TPSController::class, "store"])->name(
            "desa.tps.store",
        );
        Route::get("/desa/{desa}/tps/download", [
            TPSController::class,
            "download",
        ])->name("desa.tps.download");
    });

    /*
    |--------------------------------------------------------------------------
    | TPS (KPPS) Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(["check.role:kpps"])->group(function () {
        Route::get("/tps/{tpsId}", [TPSController::class, "index"])->name(
            "tps.index",
        );

        // Anggota KPPS
        Route::post("/kpps/{tpsId}/anggota", [
            KPPSMemberController::class,
            "store",
        ])->name("kpps.anggota.store");
        Route::put("/kpps/{id}", [KPPSMemberController::class, "update"])->name(
            "kpps.anggota.update",
        );
        Route::delete("/kpps/{id}", [
            KPPSMemberController::class,
            "destroy",
        ])->name("kpps.anggota.destroy");

        // Jumlah pemilih
        Route::put("/tps/{id}/update-voters", [
            TPSController::class,
            "updateVoters",
        ])->name("tps.update_voters");
    });

    /*
    |--------------------------------------------------------------------------
    | Upload Routes
    |--------------------------------------------------------------------------
    */
    Route::get("/upload", [UploadController::class, "index"])->name(
        "upload.index",
    );
    Route::post("/upload", [UploadController::class, "store"])->name(
        "upload.store",
    );

    /*
    |--------------------------------------------------------------------------
    | Utility Routes
    |--------------------------------------------------------------------------
    */
    Route::get("/logout", [SessionController::class, "logout"])->name("logout");

    Route::get("/get-desa-by-kecamatan/{id}", [
        LocationController::class,
        "getDesaByKecamatan",
    ]);
});

/*
|--------------------------------------------------------------------------
| Error Testing Routes
|--------------------------------------------------------------------------
*/
Route::get("/test-403", function () {
    abort(403, "Anda tidak memiliki izin untuk mengakses halaman ini.");
});
Route::get("/test-500", function () {
    throw new Exception("Error testing 500");
});

// Note:
// check clean code
// user pps 3
// user kpps 2
// delete tabel anggota kpps
// only pps can tambah tps
// verif dokumen
