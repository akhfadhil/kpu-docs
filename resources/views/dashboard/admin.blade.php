@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-indigo-100">
    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md text-center">
        <h1 class="text-2xl font-bold text-indigo-700 mb-4">Halo Admin 👋</h1>
        <p class="text-gray-600 mb-6">Selamat datang di halaman dashboard Admin.</p>
        <a href="{{ route('logout') }}" 
           class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-400 transition">
           Logout
        </a>
    </div>
</div>
@endsection
