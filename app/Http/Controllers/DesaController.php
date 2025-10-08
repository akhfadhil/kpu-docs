<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Desa;
use Illuminate\Support\Facades\Auth;

class DesaController extends Controller
{
    public function index($desaId)
    {

        $user = Auth::user();

        // Cegah PPK mengakses kecamatan lain
        if ($user->role->role === 'pps') {
            $userDesaId = $user->userable->desa_id ?? null;
            if ($userDesaId !== (int) $desaId) {
                return redirect()->route('desa.index', ['desaId' => $userDesaId])
                    ->with('error', 'Anda tidak memiliki akses ke desa lain.');
            }
        }

        // $desa = Desa::find($desaId);
        $desa = Desa::with('tps')->find($desaId);

        if (!$desa) {
            abort(404);
        }

        return view('dashboard.desa', [
            'title' => $desa->name,
            'desa' => $desa,
        ]);
    }
}
