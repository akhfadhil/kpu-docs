<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class RoleMiddleware
{
    // public function handle(Request $request, Closure $next, string $role)
    // {
    //     if (Auth::check() && Auth::user()->role->role === $role) {
    //         return $next($request);
    //     }

    //     abort(403, 'Akses ditolak.');
    // }

    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        // Jika belum login, arahkan ke halaman login
        if (!$user) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        $hierarchy = config('roles.hierarchy');
        $userRole = $user->role->role ?? null;

        // Jika role tidak dikenali
        if (!$userRole) {
            return redirect('/')->with('error', 'Role pengguna tidak dikenali.');
        }

        // Role user harus sama atau lebih tinggi dari role target
        if (
            $userRole === $role ||
            in_array($role, $hierarchy[$userRole] ?? [])
        ) {
            return $next($request);
        }

        // 🚫 Kalau tidak berhak, arahkan ke dashboard-nya sendiri
        return redirect(routeDashboard())
            ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }


}
