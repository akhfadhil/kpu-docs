<?php

use Illuminate\Support\Facades\Auth;

if (! function_exists('routeDashboard')) {
    function routeDashboard() {
        $user = Auth::user();
        $role = $user->role->role ?? 'guest';

        switch ($role) {
            case 'admin':
                return url('/admin');
            case 'ppk':
                return route('kecamatan.index', ['id' => $user->userable->kecamatan_id]);
            case 'pps':
                return route('desa.index', ['desaId' => $user->userable->desa_id]);
            case 'kpps':
                return url('/kpps');
            default:
                return url('/dashboard');
        }
    }
}
