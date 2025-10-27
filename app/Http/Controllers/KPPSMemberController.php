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

    public function edit($id)
    {
        $user = Auth::user();
        $member = \App\Models\KPPSMember::with('tps.desa.kecamatan')->findOrFail($id);

        // 🔒 Role-based access control
        if ($user->role->role === 'admin') {
            // ok
        } elseif ($user->role->role === 'ppk') {
            $userKecId = $user->userable->kecamatan_id ?? null;
            $memberKecId = $member->tps->desa->kecamatan->id ?? null;
            if ($userKecId !== $memberKecId) abort(403, 'Anda tidak memiliki izin untuk anggota ini.');
        } elseif ($user->role->role === 'pps') {
            $userDesaId = $user->userable->desa_id ?? null;
            $memberDesaId = $member->tps->desa->id ?? null;
            if ($userDesaId !== $memberDesaId) abort(403, 'Anda tidak memiliki izin untuk anggota ini.');
        } elseif ($user->role->role === 'kpps') {
            $userTpsId = $user->userable->tps_id ?? null;
            if ($userTpsId !== $member->tps_id) abort(403, 'Anda tidak memiliki izin untuk anggota TPS ini.');
        } else {
            abort(403, 'Akses ditolak.');
        }

        return view('kpps.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = \App\Models\KPPSMember::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
        ]);

        $member->update([
            'name' => $request->name,
            'job_title' => $request->job_title,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Data anggota KPPS berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $member = \App\Models\KPPSMember::findOrFail($id);

        // Otorisasi: Pastikan hanya role yang berhak bisa hapus
        $user = Auth::user();
        $role = $user->role->role ?? 'guest';
        $userable = $user->userable;

        if ($role === 'admin') {
            // admin bebas hapus
        } elseif ($role === 'ppk') {
            if ($userable->kecamatan_id !== $member->tps->desa->kecamatan_id) {
                abort(403, 'Anda tidak memiliki izin untuk menghapus anggota dari kecamatan ini.');
            }
        } elseif ($role === 'pps') {
            if ($userable->desa_id !== $member->tps->desa_id) {
                abort(403, 'Anda tidak memiliki izin untuk menghapus anggota dari desa ini.');
            }
            
        } elseif ($role === 'kpps') {
            if ($userable->tps_id !== $member->tps_id) {
                abort(403, 'Anda tidak memiliki izin untuk menghapus anggota dari tps ini.');
            }
        } else {
            abort(403, 'Anda tidak memiliki izin untuk menghapus anggota PPS.');
        }

        // Hapus data
        $member->delete();

        return redirect()
            ->back()
            ->with('success', 'Anggota berhasil dihapus!');
    }

}
