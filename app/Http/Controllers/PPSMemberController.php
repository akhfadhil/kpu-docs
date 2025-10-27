<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PPSMemberController extends Controller
{
    public function store(Request $request, $desaId)
    {
        $user = Auth::user();
        $userable = $user->userable;

        // Ambil desa terkait dari parameter
        $desa = \App\Models\Desa::with("kecamatan")->findOrFail($desaId);

        // 1️⃣ Jika admin, langsung izinkan
        if ($user->role->role === "admin") {
            // boleh lanjut
        }
        // 2️⃣ Jika PPK, pastikan kecamatan sama
        elseif ($user->role->role === "ppk") {
            $userKecId = $userable->kecamatan_id ?? null;
            $desaKecId = $desa->kecamatan->id ?? null;

            if ($userKecId !== $desaKecId) {
                abort(
                    403,
                    "Anda tidak memiliki izin untuk desa di kecamatan ini.",
                );
            }
        }
        // 3️⃣ Jika PPS, pastikan desa sama (boleh menambah anggota di desanya sendiri)
        elseif ($user->role->role === "pps") {
            $userDesaId = $userable->desa_id ?? null;
            if ((int) $userDesaId !== (int) $desaId) {
                abort(403, "Anda tidak memiliki izin untuk desa ini.");
            }
        }
        // ❌ KPPS tidak boleh menambah anggota PPS
        elseif ($user->role->role === "kpps") {
            abort(403, "KPPS tidak memiliki izin untuk menambah anggota PPS.");
        }
        // ❌ Selain itu, tolak akses
        else {
            abort(
                403,
                "Role Anda tidak memiliki izin untuk menambah anggota PPS.",
            );
        }

        // ✅ Validasi input
        $request->validate([
            "name" => "required|string|max:255",
            "job_title" => "required|string|max:255",
        ]);

        // ✅ Simpan ke tabel PPSMember
        \App\Models\PPSMember::create([
            "name" => $request->name,
            "job_title" => $request->job_title,
            "desa_id" => $desaId,
        ]);

        return redirect()
            ->route("desa.index", $desaId)
            ->with("success", "Anggota PPS berhasil ditambahkan!");
    }

    public function destroy($id)
    {
        $member = \App\Models\PPSMember::findOrFail($id);

        // Otorisasi: Pastikan hanya role yang berhak bisa hapus
        $user = Auth::user();
        $role = $user->role->role ?? 'guest';
        $userable = $user->userable;

        if ($role === 'admin') {
            // admin bebas hapus
        } elseif ($role === 'ppk') {
            if ($userable->kecamatan_id !== $member->desa->kecamatan_id) {
                abort(403, 'Anda tidak memiliki izin untuk menghapus anggota dari kecamatan ini.');
            }
        } elseif ($role === 'pps') {
            if ($userable->desa_id !== $member->desa_id) {
                abort(403, 'Anda tidak memiliki izin untuk menghapus anggota dari desa ini.');
            }
            
        }

        // Hapus data
        $member->delete();

        return redirect()
            ->back()
            ->with('success', 'Anggota berhasil dihapus!');
    }
}
