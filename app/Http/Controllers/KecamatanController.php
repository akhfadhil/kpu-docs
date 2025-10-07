<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;

class KecamatanController extends Controller
{
    public function index($id)
    {
        $kecamatan = Kecamatan::with('desa')->findOrFail($id);

        // dd($kecamatan->nama_kecamatan);
        return view('dashboard.kecamatan', [
            'title' => $kecamatan->name,
            'kecamatan' => $kecamatan,
        ]);

    }

}