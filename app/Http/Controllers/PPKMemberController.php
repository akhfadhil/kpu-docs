<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PPKMember;
use App\Models\Kecamatan;

class PPKMemberController extends Controller
{
    public function store(Request $request, $kecamatanId)
    {
        $user = Auth::user();
        $userable = $user->userable;

        // Ambil kecamatan dari parameter
        $kecamatan = Kecamatan::findOrFail($kecamatanId);

        // 1️⃣ Jika admin, langsung izinkan
        if ($user->role->role === "admin") {
            // boleh lanjut
        }
        // 2️⃣ Jika PPK, pastikan kecamatan sama
        elseif ($user->role->role === "ppk") {
            $userKecId = $userable->kecamatan_id ?? null;
            if ((int) $userKecId !== (int) $kecamatan->id) {
                abort(
                    403,
                    "Anda tidak memiliki izin untuk menambah anggota di kecamatan ini.",
                );
            }
        }
        // 3️⃣ PPS dan KPPS tidak boleh menambah
        elseif (in_array($user->role->role, ["pps", "kpps"])) {
            abort(403, "Anda tidak memiliki izin untuk menambah anggota PPK.");
        }
        // ❌ Role lain juga ditolak
        else {
            abort(
                403,
                "Role Anda tidak memiliki izin untuk menambah anggota PPK.",
            );
        }

        // ✅ Validasi input
        $request->validate([
            "name" => "required|string|max:255",
            "job_title" => "required|string|max:255",
        ]);

        // ✅ Simpan data anggota baru
        PPKMember::create([
            "name" => $request->name,
            "job_title" => $request->job_title,
            "kecamatan_id" => $kecamatan->id,
        ]);

        // ✅ Redirect ke halaman kecamatan
        return redirect()
            ->route("kecamatan.index", $kecamatan->id)
            ->with("success", "Anggota PPK berhasil ditambahkan!");
    }

    public function update(Request $request, $id)
    {
        $member = \App\Models\PPKMember::findOrFail($id);

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
            ->with("success", "Data anggota PPK berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $member = \App\Models\PPKMember::findOrFail($id);

        // Otorisasi: Pastikan hanya role yang berhak bisa hapus
        $user = Auth::user();
        $role = $user->role->role ?? "guest";
        $userable = $user->userable;

        if ($role === "admin") {
            // admin bebas hapus
        } elseif ($role === "ppk") {
            if ($userable->kecamatan_id !== $member->kecamatan_id) {
                abort(
                    403,
                    "Anda tidak memiliki izin untuk menghapus anggota dari kecamatan ini.",
                );
            }
        }

        // Hapus data
        $member->delete();

        return redirect()->back()->with("success", "Anggota berhasil dihapus!");
    }
}
