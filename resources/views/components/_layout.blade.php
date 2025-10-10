<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100 dark:bg-gray-500">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Manajemen Arsip Penyelenggara Pemilu</title>
      @vite('resources/css/app.css')
      @vite('resources/js/app.js')
      <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
      <script src="//unpkg.com/alpinejs" defer></script>
      <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
      <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon-32x32.png') }}">
   </head>
   <body class="h-full">
      @if(session('error'))
      <div 
         x-data="{ show: true }" 
         x-show="show"
         x-transition.duration.500ms
         x-init="setTimeout(() => show = false, 3000)"
         class="fixed top-6 left-1/2 transform -translate-x-1/2 
               bg-red-600 text-white px-5 py-3 rounded-xl shadow-lg 
               flex items-center space-x-2 z-50"
      >
         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
               stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 9v3.75m0 3.75h.007M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
         </svg>
         <span>{{ session('error') }}</span>
      </div>
      @endif


      <div class="min-h-full">
         <x-navbar></x-navbar>
         <x-header>{{ $title }}</x-header>
         <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
               {{$slot}}
            </div>
         </main>
      </div>
   </body>
</html>