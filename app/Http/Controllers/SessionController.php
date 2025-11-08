<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $role = $user->role->role ?? null;

            switch ($role) {
                case "admin":
                    return redirect()->route("admin");
                case "ppk":
                    return redirect()->route("kecamatan.index", [
                        "id" => $user->userable->kecamatan_id,
                    ]);
                case "pps":
                    return redirect()->route("desa.index", [
                        "desaId" => $user->userable->desa_id,
                    ]);
                case "kpps":
                    return redirect()->route("tps.index", [
                        "tpsId" => $user->userable->tps_id,
                    ]);
                default:
                    Auth::logout();
                    return redirect()
                        ->route("login")
                        ->with("error", "Role pengguna tidak dikenali.");
            }
        }

        return view("login");
    }

    public function login(Request $request)
    {
        $request->validate([
            "username" => "required",
            "password" => "required",
        ]);

        $credentials = $request->only("username", "password");

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $role = $user->role->role;

            if (!empty($user->temporary_password)) {
                return redirect()->route("password.force_change");
            }

            switch ($role) {
                case "admin":
                    return redirect()->route("admin");
                case "ppk":
                    return redirect()->route("kecamatan.index", [
                        "id" => $user->userable->kecamatan_id,
                    ]);
                case "pps":
                    return redirect()->route("desa.index", [
                        "desaId" => $user->userable->desa_id,
                    ]);
                case "kpps":
                    return redirect()->route("tps.index", [
                        "tpsId" => $user->userable->tps_id,
                    ]);
                default:
                    Auth::logout();
                    return redirect()
                        ->route("login")
                        ->with("error", "Role pengguna tidak dikenali.");
            }
        }

        return back()
            ->withErrors(["username" => "Username atau password salah."])
            ->withInput();
    }

    function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect("/");
    }
}
