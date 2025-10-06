<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function index () {
        $user = Auth::user();
        $role = $user->role->role;

        // Tampilkan view sesuai role
        return view("dashboard.$role");
    }
}
