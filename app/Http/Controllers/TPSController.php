<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TPS;


class TPSController extends Controller
{
    public function index($TPSId)
    {

        $user = Auth::user();

        // Cegah KPPS mengakses kecamatan lain
        if ($user->role->role === 'pps') {
            $userTPSId = $user->userable->tps_id ?? null;
            if ($userTPSId !== (int) $TPSId) {
                return redirect()->route('tps.index', ['TPSId' => $userTPSId])
                    ->with('error', 'Anda tidak memiliki akses ke tps lain.');
            }
        }

        $tps = TPS::with('desa.kecamatan')->findOrFail($TPSId);

        return view('dashboard.tps', [
            'title' => $tps->tps_code,
            'tps' => $tps,
        ]);
    }
}
