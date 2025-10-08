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

            default:
                abort(403, 'Role tidak dikenali.');
        }
    }
}