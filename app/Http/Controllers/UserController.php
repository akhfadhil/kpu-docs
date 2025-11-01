<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use App\Models\PPKMember;
use App\Models\PPSMember;
use App\Models\KPPSMember;

class UserController extends Controller
{
    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|string|max:255",
        ]);

        $user = User::findOrFail($id);

        // Update nama di tabel users
        $user->name = $request->name;
        $user->save();

        // Jika punya relasi polymorphic (ppk_members / pps_members)
        if ($user->userable) {
            $user->userable->update(["name" => $request->name]);
        }

        return back()->with("success", "Nama berhasil diperbarui.");
    }

    public function downloadPdf(Request $request)
    {
        $role = $request->get("role");
        $kecamatan = $request->get("kecamatan");

        $users = User::with(["role", "userable"])
            ->when(
                $role,
                fn($q) => $q->whereHas(
                    "role",
                    fn($r) => $r->where("role", $role),
                ),
            )
            ->when($kecamatan, function ($q) use ($kecamatan) {
                $q->where(function ($query) use ($kecamatan) {
                    $query
                        // PPSMember → desa.kecamatan
                        ->orWhereHasMorph(
                            "userable",
                            [PPSMember::class],
                            function ($u) use ($kecamatan) {
                                $u->whereHas("desa.kecamatan", function (
                                    $k,
                                ) use ($kecamatan) {
                                    $k->where("name", $kecamatan);
                                });
                            },
                        )
                        // KPPSMember → tps.desa.kecamatan
                        ->orWhereHasMorph(
                            "userable",
                            [KPPSMember::class],
                            function ($u) use ($kecamatan) {
                                $u->whereHas("tps.desa.kecamatan", function (
                                    $k,
                                ) use ($kecamatan) {
                                    $k->where("name", $kecamatan);
                                });
                            },
                        )
                        // PPKMember → kecamatan langsung
                        ->orWhereHasMorph(
                            "userable",
                            [PPKMember::class],
                            function ($u) use ($kecamatan) {
                                $u->whereHas("kecamatan", function ($k) use (
                                    $kecamatan,
                                ) {
                                    $k->where("name", $kecamatan);
                                });
                            },
                        );
                });
            })
            ->get();

        // Tentukan judul & nama file
        if ($role === "ppk") {
            $judul = "Daftar PPK";
            $fileName = "daftar-ppk.pdf";
        } elseif ($kecamatan) {
            $judul = "Daftar Pengguna Kecamatan " . $kecamatan;
            $fileName = "daftar-pengguna-" . Str::slug($kecamatan) . ".pdf";
        } else {
            $judul = "Daftar Pengguna";
            $fileName = "daftar-pengguna.pdf";
        }

        $pdf = Pdf::loadView(
            "pdf.daftar_pengguna",
            compact("users", "judul"),
        )->setPaper("a4", "portrait");

        return $pdf->download($fileName);
    }
}
