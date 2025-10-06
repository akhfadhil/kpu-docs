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
            return redirect()->intended('admin'); // atau route sesuai role nanti
        } else {
            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->withInput();
        }
    }
}
