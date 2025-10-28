<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Kecamatan;

class AdminController extends Controller
{
    // public function index()
    // {
    //     $user = Auth::user();
    //     $role = $user->role->role; // kolom 'role' di tabel roles

    //     switch ($role) {
    //         case 'admin':
    //             $data = [
    //                 'title' => 'Dashboard Admin',
    //                 'kecamatan' => Kecamatan::all(['id', 'name']),
    //             ];
    //             return view('dashboard.admin', $data);

    //         default:
    //             abort(403, 'Role tidak dikenali.');
    //     }
    // }

    public function index()
    {
        $user = Auth::user();
        $role = $user->role->role; // kolom 'role' di tabel roles

        switch ($role) {
            case "admin":
                $data = [
                    "title" => "Dashboard Admin",
                    "kecamatan" => Kecamatan::all(["id", "name"]),
                    "users" => \App\Models\User::with("role")->get(), // ✅ kirim data user lengkap dengan relasi role
                ];
                return view("dashboard.admin", $data);

            default:
                abort(403, "Role tidak dikenali.");
        }
    }
}
