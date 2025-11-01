<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Ubah Password - Manajemen Arsip Penyelenggara Pemilu</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon-32x32.png') }}">
</head>
<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img src="{{ asset('img/logo.png') }}" alt="Komisi Pemilihan Umum" class="mx-auto h-16 w-auto" />
            <h2 class="mt-10 text-center text-2xl font-bold tracking-tight text-white">
                Ubah Password
            </h2>
            <p class="mt-2 text-center text-sm text-gray-400">
                Anda menggunakan password sementara.<br>Silakan ubah demi keamanan akun Anda.
            </p>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            {{-- Notifikasi error --}}
            @if($errors->any())
                <div class="mb-4 rounded-lg bg-red-500/10 p-4 text-sm text-red-400">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Ubah Password --}}
            <form method="POST" action="{{ route('password.force_change.update') }}" class="space-y-6">
                @csrf

                {{-- Password Baru --}}
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-100">Password Baru</label>
                    <div class="mt-2 relative">
                        <input 
                            type="password" 
                            id="new_password" 
                            name="new_password"
                            required
                            class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 
                                   -outline-offset-1 outline-white/10 placeholder:text-gray-500 
                                   focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"
                            placeholder="Masukkan password baru"
                        />
                        {{-- Tombol toggle mata --}}
                        <button type="button" 
                            onclick="togglePassword('new_password', this)" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-200">
                            <!-- Ikon mata -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.01 9.964 7.183.07.207.07.432 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                        @error('new_password')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-100">Konfirmasi Password</label>
                    <div class="mt-2 relative">
                        <input 
                            type="password" 
                            id="new_password_confirmation" 
                            name="new_password_confirmation"
                            required
                            class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 
                                   -outline-offset-1 outline-white/10 placeholder:text-gray-500 
                                   focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"
                            placeholder="Ulangi password baru"
                        />
                        <button type="button" 
                            onclick="togglePassword('new_password_confirmation', this)" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.01 9.964 7.183.07.207.07.432 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Tombol Simpan --}}
                <div>
                    <button 
                        type="submit" 
                        class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 
                               text-sm font-semibold text-white hover:bg-indigo-400 
                               focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                        Simpan Password Baru
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script toggle password --}}
    <script>
        function togglePassword(fieldId, button) {
            const input = document.getElementById(fieldId);
            const isHidden = input.type === "password";
            input.type = isHidden ? "text" : "password";

            // Ganti ikon mata
            button.innerHTML = isHidden 
                ? `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.44 7.244 19.5 12 19.5c1.73 0 3.37-.376 4.819-1.047M9.88 9.88a3 3 0 104.24 4.24" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                  </svg>`
                : `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.01 9.964 7.183.07.207.07.432 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>`;
        }
    </script>
</body>
</html>
