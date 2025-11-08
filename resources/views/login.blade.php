<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Manajemen Arsip Penyelenggara Pemilu</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon-32x32.png') }}">

    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="h-full">

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">

        <!-- Logo & Header -->
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img src="{{ asset('img/logo.png') }}" alt="Komisi Pemilihan Umum"
                 class="mx-auto h-16 w-auto" />
            <h2 class="mt-10 text-center text-2xl font-bold tracking-tight text-white">
                Sign in to your account
            </h2>
        </div>

        <!-- Form Login -->
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-500/10 p-4 text-sm text-red-400">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/" method="POST" class="space-y-6">
                @csrf

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-100">Username</label>
                    <div class="mt-2">
                        <input id="username" type="text" name="username" required autocomplete="username"
                               class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white
                                      outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500
                                      focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm" />
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-100">Password</label>
                    <div class="mt-2 relative">
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="block w-full rounded-md bg-white/5 px-3 py-1.5 pr-10 text-base text-white
                                      outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500
                                      focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm" />

                        <!-- Tombol toggle password -->
                        <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3
                                       text-gray-400 hover:text-gray-200 focus:outline-none">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5
                                         c4.477 0 8.268 2.943 9.542 7
                                         -1.274 4.057-5.065 7-9.542 7
                                         -4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm
                                   font-semibold text-white hover:bg-indigo-400
                                   focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script: Toggle Password -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', () => {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';

            // Ganti ikon mata
            eyeIcon.outerHTML = isHidden
                ? `<svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13.875 18.825A10.05 10.05 0 0112 19
                                 c-4.477 0-8.268-2.943-9.542-7
                                 a9.97 9.97 0 012.26-3.768m4.78-2.708
                                 A9.953 9.953 0 0112 5
                                 c4.477 0 8.268 2.943 9.542 7
                                 a9.957 9.957 0 01-4.112 5.225
                                 M15 12a3 3 0 11-6 0
                                 3 3 0 016 0zM3 3l18 18" />
                    </svg>`
                : `<svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5
                                 c4.477 0 8.268 2.943 9.542 7
                                 -1.274 4.057-5.065 7-9.542 7
                                 -4.477 0-8.268-2.943-9.542-7z" />
                    </svg>`;
        });
    </script>

    @include('components.alert')
</body>

</html>
