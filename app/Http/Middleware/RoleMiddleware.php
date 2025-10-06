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

        if (!$user) {
            return redirect('/');
        }

        // Ambil hierarchy dari config
        $hierarchy = config('roles.hierarchy');

        $userRole = $user->role->role ?? null;

        // Role user harus sama atau lebih tinggi dari role target
        if (
            $userRole === $role ||
            in_array($role, $hierarchy[$userRole] ?? [])
        ) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }

}
