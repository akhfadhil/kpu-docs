<?php

use Illuminate\Support\Facades\Auth;

if (! function_exists('routeDashboard')) {
    function routeDashboard() {
        $role = Auth::user()->role->role ?? 'guest';
        return url("/{$role}");
    }
}
