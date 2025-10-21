<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\PPKMember;
use Illuminate\Support\Facades\Auth;

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

        return view("dashboard.kecamatan", [
            "title" => $kecamatan->name,
            "kecamatan" => $kecamatan,
            "anggota" => $anggota,
        ]);
    }
}
