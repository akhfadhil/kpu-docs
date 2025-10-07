<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Kecamatan;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role->role; // pastikan kolom di tabel roles bernama 'role'

        $titles = [
            'admin' => 'Dashboard Admin',
            'ppk'   => 'Dashboard PPK',
            'pps'   => 'Dashboard PPS',
            'kpps'  => 'Dashboard KPPS',
        ];

        $data = [
            'title' => $titles[$role] ?? 'Dashboard',
        ];

        // Tambahkan data tambahan sesuai role
        if (in_array($role, ['admin', 'ppk', 'pps'])) {
            $data['kecamatan'] = Kecamatan::all(['id', 'name']);
        }

        return view("dashboard.$role", $data);
    }
}