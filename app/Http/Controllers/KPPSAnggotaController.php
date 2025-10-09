<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TPS;
use App\Models\KPPSMember;

class KPPSAnggotaController extends Controller
{
    public function store(Request $request, $tpsId)
    {
        $userTpsId = Auth::user()->userable->tps_id ?? null;
        if ((int)$userTpsId !== (int)$tpsId) {
            abort(403, 'Anda tidak memiliki izin untuk TPS ini.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
        ]);

        KPPSMember::create([
            'name' => $request->name,
            'job_title' => $request->job_title,
            'tps_id' => $tpsId,
        ]);

        return redirect()->route('tps.index', $tpsId)
            ->with('success', 'Anggota KPPS berhasil ditambahkan!');
    }
}
