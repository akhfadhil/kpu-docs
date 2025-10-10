<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <meta content="width=device-width, initial-scale=1.0" name="viewport" />
      <title>Manajemen Aplikasi Penyelenggara Pemilu</title>
      {{-- Tailwind + Flowbite --}}
      @vite(['resources/css/app.css', 'resources/js/app.js'])
      <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
      <script src="https://unpkg.com/flowbite@2.5.2/dist/flowbite.min.js"></script>
      <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
      <script src="//unpkg.com/alpinejs" defer></script>
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
      <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon-32x32.png') }}">
      <script>
         tailwind.config = {
           darkMode: "class",
           theme: {
             extend: {
               colors: {
                 primary: "#4F46E5",
                 "background-light": "#F3F4F6",
                 "background-dark": "#1F2937",
                 "card-light": "#FFFFFF",
                 "card-dark": "#374151",
                 "text-light": "#111827",
                 "text-dark": "#F9FAFB",
                 "text-secondary-light": "#6B7280",
                 "text-secondary-dark": "#D1D5DB",
                 "border-light": "#E5E7EB",
                 "border-dark": "#4B5563",
               },
               fontFamily: {
                 display: ["Inter", "sans-serif"],
               },
               borderRadius: {
                 DEFAULT: "0.5rem",
               },
             },
           },
         };
      </script>
   </head>
   <body class="font-display bg-background-light dark:bg-background-dark text-text-light dark:text-text-dark">
      <div class="min-h-screen flex flex-col">
      {{-- HEADER --}}
      <x-header></x-header>
      {{-- MAIN --}}
      <main class="flex-grow">
         {{ $slot }}
      </main>
      {{-- FOOTER --}}
      <footer class="bg-card-light dark:bg-card-dark mt-12">
         <div class="container mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-text-secondary-light dark:text-text-secondary-dark">
               © 2023 PemiluApp. All rights reserved.
            </p>
         </div>
      </footer>
         <script src="https://unpkg.com/flowbite@2.4.1/dist/flowbite.min.js"></script>
   </body>


</html>