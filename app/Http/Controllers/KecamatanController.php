<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\PPKMember;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;

class KecamatanController extends Controller
{
    public function index($id)
    {
        $user = Auth::user();

        // Cegah PPK mengakses kecamatan lain
        if ($user->role->role === "ppk") {
            $userKecamatanId = $user->userable->kecamatan_id ?? null;

            if ($userKecamatanId !== (int) $id) {
                return redirect()
                    ->route("kecamatan.index", ["id" => $userKecamatanId])
                    ->with(
                        "error",
                        "Anda tidak memiliki akses ke kecamatan lain.",
                    );
            }
        }

        $kecamatan = Kecamatan::with("desa")->findOrFail($id);
        $anggota = PPKMember::where("kecamatan_id", $kecamatan->id)->get();
        $announcement = Announcement::where("role", "ppk")->latest()->first();

        return view("dashboard.kecamatan", [
            "title" => $kecamatan->name,
            "kecamatan" => $kecamatan,
            "anggota" => $anggota,
            "announcement" => $announcement,
        ]);
    }
}
