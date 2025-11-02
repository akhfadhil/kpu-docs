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
                return back()
                    ->with(
                        "error",
                        "Anda tidak memiliki izin untuk TPS di kecamatan ini.",
                    )
                    ->with("toast", true);
            }
        }
        // 3️⃣ Jika PPS, pastikan desa sama
        elseif ($user->role->role === "pps") {
            $userDesaId = $userable->desa_id ?? null;
            $tpsDesaId = $tps->desa->id ?? null;

            if ($userDesaId !== $tpsDesaId) {
                return back()
                    ->with(
                        "error",
                        "Anda tidak memiliki izin untuk TPS di desa ini.",
                    )
                    ->with("toast", true);
            }
        }
        // 4️⃣ Jika KPPS, pastikan TPS sama
        elseif ($user->role->role === "kpps") {
            $userTpsId = $userable->tps_id ?? null;

            if ((int) $userTpsId !== (int) $tpsId) {
                return back()
                    ->with("error", "Anda tidak memiliki izin untuk TPS ini.")
                    ->with("toast", true);
            }
        }
        // ❌ Selain role di atas, tolak akses
        else {
            return back()
                ->with("error", "Anda tidak memiliki izin untuk menambah TPS")
                ->with("toast", true);
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
            ->with("success", "Anggota KPPS berhasil ditambahkan!")
            ->with("toast", true);
    }

    public function update(Request $request, $id)
    {
        $member = \App\Models\KPPSMember::findOrFail($id);

        $request->validate([
            "name" => "required|string|max:255",
            "job_title" => "required|string|max:255",
        ]);

        $member->update([
            "name" => $request->name,
            "job_title" => $request->job_title,
        ]);

        return redirect()
            ->back()
            ->with("success", "Data anggota KPPS berhasil diperbarui.")
            ->with("toast", true);
    }

    public function destroy($id)
    {
        $member = \App\Models\KPPSMember::findOrFail($id);

        // Otorisasi: Pastikan hanya role yang berhak bisa hapus
        $user = Auth::user();
        $role = $user->role->role ?? "guest";
        $userable = $user->userable;

        if ($role === "admin") {
            // admin bebas hapus
        } elseif ($role === "ppk") {
            if ($userable->kecamatan_id !== $member->tps->desa->kecamatan_id) {
                return back()
                    ->with(
                        "error",
                        "Anda tidak memiliki izin untuk menghapus anggota dari kecamatan ini.",
                    )
                    ->with("toast", true);
            }
        } elseif ($role === "pps") {
            if ($userable->desa_id !== $member->tps->desa_id) {
                return back()
                    ->with(
                        "error",
                        "Anda tidak memiliki izin untuk menghapus anggota dari desa ini.",
                    )
                    ->with("toast", true);
            }
        } elseif ($role === "kpps") {
            if ($userable->tps_id !== $member->tps_id) {
                return back()
                    ->with(
                        "error",
                        "Anda tidak memiliki izin untuk menghapus anggota dari TPS ini.",
                    )
                    ->with("toast", true);
            }
        } else {
            return back()
                ->with(
                    "error",
                    "Anda tidak memiliki izin untuk menghapus anggota PPS.",
                )
                ->with("toast", true);
        }

        // Hapus data
        $member->delete();

        return redirect()
            ->back()
            ->with("success", "Anggota berhasil dihapus!")
            ->with("toast", true);
    }
}
