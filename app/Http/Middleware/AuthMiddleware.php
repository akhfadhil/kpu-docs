<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Jika belum login, redirect ke halaman login
            return redirect('/')->withErrors('Silakan login terlebih dahulu.'); // Atau gunakan URL langsung: redirect('/login')
        }
        return $next($request);
    }
}
