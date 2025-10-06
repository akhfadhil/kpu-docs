@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-yellow-100">
    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md text-center">
        <h1 class="text-2xl font-bold text-yellow-700 mb-4">Halo PPS 👋</h1>
        <p class="text-gray-600 mb-6">Selamat datang di dashboard Panitia Pemungutan Suara.</p>
        <a href="{{ route('logout') }}" 
           class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-400 transition">
           Logout
        </a>
    </div>
</div>
@endsection
