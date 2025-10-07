<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    function index () {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // penting untuk keamanan session fixation
            $user = Auth::user();
            $role = $user->role->role;

            switch ($role) {
                case 'admin':
                    return redirect()->intended('/admin');
                case 'ppk':
                    return redirect()->route('kecamatan.index', ['id' => $user->userable->kecamatan_id]);
                case 'pps':
                    return redirect()->intended('/pps');
                    // return redirect()->route('desa.index', ['id' => $user->userable->desa_id]);
                case 'kpps':
                    return redirect()->intended('/kpps');
                    // return redirect()->route('kpps');
                default:
                    return redirect()->intended('/dashboard');
            }
        } 
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput();
    }

    function logout () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }
}
