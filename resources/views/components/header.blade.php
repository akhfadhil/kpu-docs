<header class="bg-card-light dark:bg-card-dark shadow-md relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Kiri: Logo + Menu -->
            <div class="flex items-center space-x-6">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-8 w-auto" />
                    <span class="text-xl font-bold">MAPP</span>
                </div>

                <!-- Menu (desktop only) -->
                @php
                    $user = Auth::user();
                    $role = $user->role->role ?? 'guest';

                    $activePatterns = [
                        'admin' => 'admin*',
                        'ppk' => 'kecamatan*',
                        'pps' => 'desa*',
                        'kpps' => 'tps*',
                    ];

                    $activePattern = $activePatterns[$role] ?? 'dashboard*';
                @endphp

                <nav class="hidden md:flex space-x-4">
                    {{-- Dashboard --}}
                    <a href="{{ routeDashboard() }}" :active="request()->is($activePattern)"
                        class="{{ request()->is($activePattern)
                            ? 'bg-primary/10 text-primary'
                            : 'text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-100 dark:hover:bg-gray-700' }}
                               flex items-center space-x-2 px-3 py-2 rounded-md text-sm font-medium">
                        <span class="material-icons text-base">dashboard</span>
                        <span>Dashboard</span>
                    </a>

                    {{-- Upload --}}
                    @if ($role === 'pps')
                        {{-- Nonaktif untuk role PPS --}}
                        <a href="#" onclick="return false;"
                            class="cursor-not-allowed opacity-50 relative group flex items-center space-x-2 px-3 py-2 rounded-md text-sm font-medium 
                                   text-text-secondary-light dark:text-text-secondary-dark bg-gray-100 dark:bg-gray-700">
                            <span class="material-icons text-base">upload</span>
                            <span>Upload</span>
                            {{-- Tooltip --}}
                            <span class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 
                                         group-hover:opacity-100 transition">
                                Hanya PPK yang bisa upload
                            </span>
                        </a>
                    @else
                        {{-- Aktif untuk role lain --}}
                        <a href="/upload" :active="request()->is('upload')"
                            class="{{ request()->is('upload')
                                ? 'bg-primary/10 text-primary'
                                : 'text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-100 dark:hover:bg-gray-700' }}
                                   flex items-center space-x-2 px-3 py-2 rounded-md text-sm font-medium">
                            <span class="material-icons text-base">upload</span>
                            <span>Upload</span>
                        </a>
                    @endif
                </nav>
            </div>
            <!-- Kanan: Toggle + Icon User + Burger Menu -->
            <div class="flex items-center space-x-3">
                <!-- 🌙 Toggle Dark Mode -->
                <button id="theme-toggle" type="button"
                    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700
                           focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700
                           rounded-full p-2.5 transition">
                    <!-- Dark icon -->
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 
                                 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <!-- Light icon -->
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M10 2a1 1 0 011 1v1a1 1 0 
                               11-2 0V3a1 1 0 011-1zm4 
                               8a4 4 0 11-8 0 4 4 0 018 
                               0zm-.464 4.95l.707.707a1 
                               1 0 001.414-1.414l-.707-.707a1 
                               1 0 00-1.414 1.414zm2.12-10.607a1 
                               1 0 010 1.414l-.706.707a1 1 0 
                               11-1.414-1.414l.707-.707a1 1 0 
                               011.414 0zM17 11a1 1 0 
                               100-2h-1a1 1 0 100 2h1zm-7 
                               4a1 1 0 011 1v1a1 1 0 
                               11-2 0v-1a1 1 0 011-1zM5.05 
                               6.464A1 1 0 106.465 5.05l-.708-.707a1 
                               1 0 00-1.414 1.414l.707.707zm1.414 
                               8.486l-.707.707a1 1 0 
                               01-1.414-1.414l.707-.707a1 1 0 
                               011.414 1.414zM4 11a1 1 0 
                               100-2H3a1 1 0 000 2h1z">
                        </path>
                    </svg>
                </button>

                <!-- Icon user (hidden on mobile) -->
                <div class="relative hidden md:block">
                    <button id="userMenuButton"
                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700
                               focus:outline-none focus:ring-2 focus:ring-primary"
                        type="button">
                        <span class="material-icons text-text-secondary-light dark:text-text-secondary-dark">person</span>
                    </button>

                    <!-- Dropdown user -->
                    <div id="profileDropdown"
                        class="hidden absolute right-0 mt-2 w-44 bg-white dark:bg-gray-800
                               border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700
                                           rounded-md flex items-center space-x-2">
                                    <span class="material-icons text-sm">info</span>
                                    <span>{{ Auth::user()->name ?? 'Guest' }}</span>
                                </a>
                            </li>
                            <li>
                                <form method="GET" action="{{ route('logout') }}">
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100
                                               dark:hover:bg-gray-700 rounded-md flex items-center space-x-2">
                                        <span class="material-icons text-sm">logout</span>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Burger icon (mobile only) -->
                <button id="burgerButton"
                    class="md:hidden p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700
                           focus:outline-none focus:ring-2 focus:ring-primary">
                    <span class="material-icons text-text-secondary-light dark:text-text-secondary-dark">menu</span>
                </button>
            </div>
        </div>
    </div>
    <!-- Burger dropdown (mobile menu) -->
    <div id="mobileMenu"
        class="transition-all hidden md:hidden absolute top-16 inset-x-0 bg-white dark:bg-gray-800
               border-t border-gray-200 dark:border-gray-700 shadow-lg z-40">
        <div class="px-4 py-3 space-y-2">
            <a href="{{ routeDashboard() }}" :active="request()->is($activePattern)"
                class="flex items-center space-x-2 text-gray-700 dark:text-gray-200
                       hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md px-3 py-2">
                <span class="material-icons text-base">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a href="/upload" :active="request()->is('upload')"
                class="flex items-center space-x-2 text-gray-700 dark:text-gray-200
                       hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md px-3 py-2">
                <span class="material-icons text-base">upload</span>
                <span>Upload</span>
            </a>
            <a href="#"
                class="flex items-center space-x-2 text-gray-700 dark:text-gray-200
                       hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md px-3 py-2">
                <span class="material-icons text-base">info</span>
                <span>{{ Auth::user()->name ?? 'Guest' }}</span>
            </a>
            <form method="GET" action="{{ route('logout') }}">
                <button type="submit"
                    class="w-full text-left flex items-center space-x-2 text-gray-700 dark:text-gray-200
                           hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md px-3 py-2">
                    <span class="material-icons text-base">logout</span>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Change the icons inside the button based on previous settings
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {

            // toggle icons inside button
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // if set via local storage previously
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }

            // if NOT set via local storage previously
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
            
        });
    </script>
</header>
