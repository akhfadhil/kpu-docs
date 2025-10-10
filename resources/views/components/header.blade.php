<header class="bg-card-light dark:bg-card-dark shadow-md relative">
   <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
         <!-- Kiri: Logo + Menu -->
         <div class="flex items-center space-x-6">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
               <img
                  src="{{ asset('img/logo.png') }}"
                  alt="Logo"
                  class="h-8 w-auto"
                  />
               <span class="text-xl font-bold">MAPP</span>
            </div>
            <!-- Menu (desktop only) -->
            @php
            $user = Auth::user();
            $role = $user->role->role ?? 'guest';
            $activePatterns = [
            'admin' => 'admin*',
            'ppk'   => 'kecamatan*',
            'pps'   => 'desa*',
            'kpps'  => 'tps*',
            ];
            $activePattern = $activePatterns[$role] ?? 'dashboard*';
            @endphp
            <nav class="hidden md:flex space-x-4">
               <a href="{{ routeDashboard() }}" :active="request()->is($activePattern)"
                  class="{{ request()->is($activePattern) ? 'bg-primary/10 text-primary' : 'text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-100 dark:hover:bg-gray-700' }} flex items-center space-x-2 px-3 py-2 rounded-md text-sm font-medium ">
               <span class="material-icons text-base">dashboard</span>
               <span>Dashboard</span>
               </a>
               <a href="/upload" :active="request()->is('upload')"
                  class="{{ request()->is('upload') ? 'bg-primary/10 text-primary' : 'text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-100 dark:hover:bg-gray-700' }} flex items-center space-x-2 px-3 py-2 rounded-md text-sm font-medium ">
               <span class="material-icons text-base">upload</span>
               <span>Upload</span>
               </a>
            </nav>
         </div>
         <!-- Kanan: Icon User (desktop only) + Burger Menu -->
         <div class="flex items-center space-x-3">
            <!-- Icon user (hidden on mobile) -->
            <div class="relative hidden md:block">
               <button
                  id="userMenuButton"
                  class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary"
                  type="button">
               <span class="material-icons text-text-secondary-light dark:text-text-secondary-dark">person</span>
               </button>
               <!-- Dropdown user -->
               <div
                  id="profileDropdown"
                  class="hidden absolute right-0 mt-2 w-44 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg">
                  <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                     <li>
                        <a href="#"
                           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md flex items-center space-x-2">
                        <span class="material-icons text-sm">info</span>
                        <span>{{ Auth::user()->name ?? 'Guest' }}</span>
                        </a>
                     </li>
                     <li>
                        <form method="GET" action="{{ route('logout') }}">
                           <button type="submit"
                              class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md flex items-center space-x-2">
                           <span class="material-icons text-sm">logout</span>
                           <span>Logout</span>
                           </button>
                        </form>
                     </li>
                  </ul>
               </div>
            </div>
            <!-- Burger icon (mobile only) -->
            <button
               id="burgerButton"
               class="md:hidden p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary">
            <span class="material-icons text-text-secondary-light dark:text-text-secondary-dark">menu</span>
            </button>
         </div>
      </div>
   </div>
   <!-- Burger dropdown (mobile menu) -->
   <div
      id="mobileMenu"
      class="hidden md:hidden absolute top-16 inset-x-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-lg z-40">
      <div class="px-4 py-3 space-y-2">
         <a href="{{ routeDashboard() }}" :active="request()->is($activePattern)"
            class="flex items-center space-x-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md px-3 py-2">
         <span class="material-icons text-base">dashboard</span>
         <span>Dashboard</span>
         </a>
         <a href="/upload" :active="request()->is('upload')"
            class="flex items-center space-x-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md px-3 py-2">
         <span class="material-icons text-base">upload</span>
         <span>Upload</span>
         </a>
         <a href="#"
            class="flex items-center space-x-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md px-3 py-2">
         <span class="material-icons text-base">info</span>
         <span>{{ Auth::user()->name ?? 'Guest' }}</span>
         </a>
         <form method="GET" action="{{ route('logout') }}">
            <button type="submit"
               class="w-full text-left flex items-center space-x-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md px-3 py-2">
            <span class="material-icons text-base">logout</span>
            <span>Logout</span>
            </button>
         </form>
      </div>
   </div>
</header>