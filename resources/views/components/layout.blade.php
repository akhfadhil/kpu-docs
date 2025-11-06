<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <meta content="width=device-width, initial-scale=1.0" name="viewport" />
      <title>Manajemen Aplikasi Penyelenggara Pemilu</title>
      <script>
         // On page load or when changing themes, best to add inline in `head` to avoid FOUC
         if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
         } else {
            document.documentElement.classList.remove('dark')
         }
      </script>

      {{-- Tailwind + Flowbite --}}
      @vite(['resources/css/app.css', 'resources/js/app.js'])
      <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
      <script src="https://unpkg.com/flowbite@2.5.2/dist/flowbite.min.js"></script>
      <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
      <script src="//unpkg.com/alpinejs" defer></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
               © 2025 PemiluApp. All rights reserved.
            </p>
         </div>
      </footer>
      <script src="https://unpkg.com/flowbite@2.4.1/dist/flowbite.min.js"></script>

      <script>
         document.addEventListener("DOMContentLoaded", function () {
         // === MOBILE BURGER MENU ===
         const burgerButton = document.getElementById("burgerButton");
         const mobileMenu = document.getElementById("mobileMenu");

         if (burgerButton && mobileMenu) {
            burgerButton.addEventListener("click", (e) => {
               e.stopPropagation();
               mobileMenu.classList.toggle("hidden");

               if (!mobileMenu.classList.contains("hidden")) {
               mobileMenu.classList.add("animate-slide-down");
               } else {
               mobileMenu.classList.remove("animate-slide-down");
               }
            });

            // Klik di luar menu burger
            document.addEventListener("click", (e) => {
               if (!burgerButton.contains(e.target) && !mobileMenu.contains(e.target)) {
               mobileMenu.classList.add("hidden");
               }
            });
         }

         // === DESKTOP USER DROPDOWN ===
         const userMenuButton = document.getElementById("userMenuButton");
         const profileDropdown = document.getElementById("profileDropdown");

         if (userMenuButton && profileDropdown) {
            userMenuButton.addEventListener("click", (e) => {
               e.stopPropagation();
               const isHidden = profileDropdown.classList.contains("hidden");

               // Tutup dulu biar reset animasinya
               profileDropdown.classList.add("hidden");
               profileDropdown.classList.remove("scale-100", "opacity-100");

               if (isHidden) {
               profileDropdown.classList.remove("hidden");
               setTimeout(() => {
                  profileDropdown.classList.remove("scale-95", "opacity-0");
                  profileDropdown.classList.add("scale-100", "opacity-100");
               }, 10);
               }
            });

            // Klik di luar dropdown user
            document.addEventListener("click", (e) => {
               if (
               !userMenuButton.contains(e.target) &&
               !profileDropdown.contains(e.target)
               ) {
               profileDropdown.classList.add("scale-95", "opacity-0");
               setTimeout(() => profileDropdown.classList.add("hidden"), 150);
               }
            });
         }
         });
      </script>

@include('components.alert')

   </body>


</html>