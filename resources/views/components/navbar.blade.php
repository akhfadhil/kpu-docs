<nav class="bg-gray-800 dark:bg-gray-800/50">
   <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">
         <div class="flex items-center">
            <div class="shrink-0">
               <img src="{{ asset('img/logo.png') }}" alt="KPU Logo" class="size-8" />
            </div>
            <div class="hidden md:block">
               <div class="ml-10 flex items-baseline space-x-4">
                  <!-- Current: "bg-gray-900 dark:bg-gray-950/50 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
                  <!-- <x-nav-link href="/admin" :active="request()->is('/admin')">Dashboard</x-nav-link>
                  <x-nav-link href="/upload" :active="request()->is('upload')">Upload</x-nav-link> -->
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
                  <x-nav-link href="{{ routeDashboard() }}" :active="request()->is($activePattern)">
                     Dashboard
                  </x-nav-link>
                  <x-nav-link href="/upload" :active="request()->is('upload')">
                     Upload
                  </x-nav-link>
               </div>
            </div>
         </div>
         <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6">
               <!-- Profile dropdown -->
               <el-dropdown class="relative ml-3">
                  <button class="relative flex max-w-xs items-center rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                  <span class="absolute -inset-1.5"></span>
                  <span class="sr-only">Open user menu</span>
                  <!-- <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-8 rounded-full outline -outline-offset-1 outline-white/10" />
                  --> 
                  <svg xmlns="http://www.w3.org/2000/svg" 
                     viewBox="0 0 24 24" 
                     fill="none" 
                     stroke="currentColor" 
                     stroke-width="1.5" 
                     class="size-10 rounded-full bg-gray-800 p-2 text-gray-200">
                     <path stroke-linecap="round" stroke-linejoin="round" 
                           d="M15.75 7.5a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0zM4.5 19.5a8.25 8.25 0 0 1 15 0" />
                  </svg>
                  </button> 
                  <el-menu anchor="bottom end" popover class="w-48 origin-top-right rounded-md bg-white py-1 shadow-lg outline-1 outline-black/5 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in dark:bg-gray-800 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10">
                     <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 focus:bg-gray-100 focus:outline-hidden dark:text-gray-300 dark:focus:bg-white/5">Sign out</a>
                  </el-menu>
               </el-dropdown>
            </div>
         </div>
         <div class="-mr-2 flex md:hidden">
            <!-- Mobile menu button -->
            <button type="button" command="--toggle" commandfor="mobile-menu" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500">
               <span class="absolute -inset-0.5"></span>
               <span class="sr-only">Open main menu</span>
               <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 in-aria-expanded:hidden">
                  <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
               </svg>
               <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 not-in-aria-expanded:hidden">
                  <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
               </svg>
            </button>
         </div>
      </div>
   </div>
   <el-disclosure id="mobile-menu" hidden class="block md:hidden">
      <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
         <!-- Current: "bg-gray-900 dark:bg-gray-950/50 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
         <!-- <x-nav-link-mobile href="/admin" :active="request()->is('/')">Dashboard</x-nav-link-mobile>
         <x-nav-link-mobile href="/upload" :active="request()->is('upload')">Upload</x-nav-link-mobile> -->
         <x-nav-link-mobile href="{{ routeDashboard() }}" :active="request()->is(Auth::user()->role->role ?? '')">
            Dashboard
         </x-nav-link-mobile>

         <x-nav-link-mobile href="/upload" :active="request()->is('upload')">
            Upload
         </x-nav-link-mobile>
      </div>
      <div class="border-t border-white/10 pt-4 pb-3">
         <div class="flex items-center px-5">
            <div class="shrink-0">
               <svg xmlns="http://www.w3.org/2000/svg" 
                  viewBox="0 0 24 24" 
                  fill="none" 
                  stroke="currentColor" 
                  stroke-width="1.5" 
                  class="size-10 rounded-full bg-gray-800 p-2 text-gray-200">
                  <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M15.75 7.5a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0zM4.5 19.5a8.25 8.25 0 0 1 15 0" />
               </svg>
            </div>
            <div class="ml-3">
               <div class="text-base/5 font-medium text-white">
                  {{ Auth::user()->name ?? 'Guest' }}
               </div>
               <div class="text-sm font-medium text-gray-400">
                  {{ Auth::user()->role->role ?? '-' }}
               </div>
            </div>
         </div>
         <div class="mt-3 space-y-1 px-2">
            <a href="/logout" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">Sign out</a>
         </div>
      </div>
   </el-disclosure>
</nav>