<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Desa;

class LocationController extends Controller
{
    public function getDesaByKecamatan($kecamatan_id)
    {
        try {
            $desa = Desa::where('kecamatan_id', $kecamatan_id)->get(['id', 'name']);
            return response()->json($desa);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve villages.'], 500);
        }
    }
}
