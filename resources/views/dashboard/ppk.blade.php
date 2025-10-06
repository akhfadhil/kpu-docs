@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-green-100">
    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md text-center">
        <h1 class="text-2xl font-bold text-green-700 mb-4">Halo PPK 🙌</h1>
        <p class="text-gray-600 mb-6">Ini halaman utama untuk Panitia Pemilihan Kecamatan.</p>
        <a href="{{ route('logout') }}" 
           class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-400 transition">
           Logout
        </a>
    </div>
</div>
@endsection
