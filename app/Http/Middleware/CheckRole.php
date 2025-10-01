<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (! $request->user()) return redirect()->route('login');
        if (! in_array($request->user()->role->role, $roles)) {
            abort(403, 'Unauthorized.');
        }
        return $next($request);
    }
}
