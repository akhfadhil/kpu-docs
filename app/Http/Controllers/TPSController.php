<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TPS;
use App\Models\KPPSMember;


class TPSController extends Controller
{
    public function index($tpsId)
    {

        $user = Auth::user();

        // Cegah KPPS mengakses kecamatan lain
        if ($user->role->role === 'kpps') {
            $userTPSId = $user->userable->tps_id ?? null;
            if ($userTPSId !== (int) $tpsId) {
                // dd($userTPSId);
                return redirect()->route('tps.index', ['tpsId' => $userTPSId])
                    ->with('error', 'Anda tidak memiliki akses ke tps lain.');
            }
        }

        $tps = TPS::with('desa.kecamatan')->findOrFail($tpsId);
        $anggota = KPPSMember::where('tps_id', $tpsId)->get();

        return view('dashboard.tps', [
            'title' => $tps->tps_code,
            'tps' => $tps,
            'tpsId' => $tps->id,
            'anggota' => $anggota
        ]);
    }
}
