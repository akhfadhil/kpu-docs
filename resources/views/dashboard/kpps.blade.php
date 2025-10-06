@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-pink-100">
    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md text-center">
        <h1 class="text-2xl font-bold text-pink-700 mb-4">Halo KPPS 🙋‍♂️</h1>
        <p class="text-gray-600 mb-6">Ini halaman dashboard Kelompok Penyelenggara Pemungutan Suara.</p>
        <a href="{{ route('logout') }}" 
           class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-400 transition">
           Logout
        </a>
    </div>
</div>
@endsection
