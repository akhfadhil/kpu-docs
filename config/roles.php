<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Role Hierarchy
    |--------------------------------------------------------------------------
    | Setiap role dapat mengakses role di bawahnya.
    | Contoh: admin bisa akses semua (ppk, pps, kpps).
    | Urut dari yang paling tinggi ke paling rendah.
    |--------------------------------------------------------------------------
    */

    'hierarchy' => [
        'admin' => ['ppk', 'pps', 'kpps'],
        'ppk'   => ['pps', 'kpps'],
        'pps'   => ['kpps'],
        'kpps'  => [],
    ],

];
