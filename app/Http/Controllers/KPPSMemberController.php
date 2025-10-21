<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TPS;
use App\Models\KPPSMember;

class KPPSMemberController extends Controller
{
    public function store(Request $request, $tpsId)
    {
        $user = Auth::user();
        $userable = $user->userable;

        // Ambil tps terkait dari parameter
        $tps = \App\Models\TPS::with("desa.kecamatan")->findOrFail($tpsId);

        // 1️⃣ Jika admin, langsung izinkan
        if ($user->role->role === "admin") {
            // boleh lanjut
        }
        // 2️⃣ Jika PPK, pastikan kecamatan sama
        elseif ($user->role->role === "ppk") {
            $userKecId = $userable->kecamatan_id ?? null;
            $tpsKecId = $tps->desa->kecamatan->id ?? null;

            if ($userKecId !== $tpsKecId) {
                abort(
                    403,
                    "Anda tidak memiliki izin untuk TPS di kecamatan ini.",
                );
            }
        }
        // 3️⃣ Jika PPS, pastikan desa sama
        elseif ($user->role->role === "pps") {
            $userDesaId = $userable->desa_id ?? null;
            $tpsDesaId = $tps->desa->id ?? null;

            if ($userDesaId !== $tpsDesaId) {
                abort(403, "Anda tidak memiliki izin untuk TPS di desa ini.");
            }
        }
        // 4️⃣ Jika KPPS, pastikan TPS sama
        elseif ($user->role->role === "kpps") {
            $userTpsId = $userable->tps_id ?? null;

            if ((int) $userTpsId !== (int) $tpsId) {
                abort(403, "Anda tidak memiliki izin untuk TPS ini.");
            }
        }
        // ❌ Selain role di atas, tolak akses
        else {
            abort(
                403,
                "Role Anda tidak memiliki izin untuk menambah anggota KPPS.",
            );
        }

        $request->validate([
            "name" => "required|string|max:255",
            "job_title" => "required|string|max:255",
        ]);

        KPPSMember::create([
            "name" => $request->name,
            "job_title" => $request->job_title,
            "tps_id" => $tpsId,
        ]);

        return redirect()
            ->route("tps.index", $tpsId)
            ->with("success", "Anggota KPPS berhasil ditambahkan!");
    }
}
