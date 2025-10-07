<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Kecamatan;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role->role; // kolom 'role' di tabel roles

        switch ($role) {
            case 'admin':
                $data = [
                    'title' => 'Dashboard Admin',
                    'kecamatan' => Kecamatan::all(['id', 'name']),
                ];
                return view('dashboard.admin', $data);

            case 'pps':
                $desaId = $user->desa_id ?? $user->desa->id ?? null;
                if ($desaId) {
                    return redirect()->route('desa.show', ['desaId' => $desaId]);
                }
                return redirect('/')->with('error', 'Desa belum terhubung dengan akun Anda.');

            case 'kpps':
                $tpsId = $user->tps_id ?? $user->tps->id ?? null;
                if ($tpsId) {
                    return redirect()->route('tps.show', ['tpsId' => $tpsId]);
                }
                return redirect('/')->with('error', 'TPS belum terhubung dengan akun Anda.');

            default:
                abort(403, 'Role tidak dikenali.');
        }
    }
}