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
<div class="bg-gray-800 dark:bg-gray-900 shadow-inner">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
         <h1 class="text-2xl sm:text-3xl font-bold text-white text-center sm:text-left">
            TPS {{ $tps->tps_code }}
         </h1>
      </div>
   </div>
   <div class="container mx-auto px-4 sm:px-6 lg:px-8  relative z-10">
      {{-- Card Utama --}}
      <div class="bg-card-light dark:bg-card-dark rounded-lg shadow-lg p-4 sm:p-8 space-y-8 relative">
         <nav aria-label="Breadcrumb" class="mb-6 overflow-x-auto">
            <ol class="flex items-center space-x-2 text-sm" role="list">
               <li><a href="#" class="text-gray-500 hover:text-primary whitespace-nowrap">Provinsi Jawa Timur</a></li>
               <li><span class="material-icons text-gray-400 text-sm">chevron_right</span></li>
               <li><a href="#" class="text-gray-500 hover:text-primary whitespace-nowrap">Kabupaten Banyuwangi</a></li>
               <li><span class="material-icons text-gray-400 text-sm">chevron_right</span></li>
               <li><a href="#" class="text-gray-500 hover:text-primary whitespace-nowrap">Kecamatan {{ $tps->desa->kecamatan->name }}</a></li>
               <li><span class="material-icons text-gray-400 text-sm">chevron_right</span></li>
               <li><a href="#" class="text-gray-500 hover:text-primary whitespace-nowrap">Desa {{ $tps->desa->name }}</a></li>
               <li><span class="material-icons text-gray-400 text-sm">chevron_right</span></li>
               <li><a href="#" class="text-gray-900 dark:text-white font-medium whitespace-nowrap">TPS {{ $tps->tps_code }}</a></li>
            </ol>
         </nav>
         {{-- Detail tps --}}
         <section>
            <div class="mb-8">
               <h2 class="text-2xl font-bold text-text-light dark:text-text-dark mb-4">Detail TPS {{ $tps->tps_code }}</h2>
               <div class="border border-border-light dark:border-border-dark rounded-lg overflow-hidden">
                  <table class="w-full">
                     <tbody class="divide-y divide-border-light dark:divide-border-dark">
                        <tr class="divide-x divide-border-light dark:divide-border-dark">
                           <td class="px-4 py-3 font-medium text-text-secondary-light dark:text-text-secondary-dark w-1/3">Alamat</td>
                           <td class="px-4 py-3 text-text-light dark:text-text-dark">{{ $tps->address }}</td>
                        </tr>
                        <tr class="divide-x divide-border-light dark:divide-border-dark">
                           <td class="px-4 py-3 font-medium text-text-secondary-light dark:text-text-secondary-dark w-1/3">Jumlah Pemilih</td>
                           <td class="px-4 py-3 text-text-light dark:text-text-dark">{{ $tps->number_of_voters }}</td>
                        </tr>
                        <tr class="divide-x divide-border-light dark:divide-border-dark">
                           <td class="px-4 py-3 font-medium text-text-secondary-light dark:text-text-secondary-dark w-1/3">Ketua KPPS</td>
                           <td class="px-4 py-3 text-text-light dark:text-text-dark">{{ $tps->ketua_kpps->name }}</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
            {{-- dokumen --}}
            <div class="mb-8">
               <h3 class="text-xl font-bold text-text-light dark:text-text-dark mb-4">Dokumen C Hasil</h3>
               <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                  <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg flex flex-col items-center text-center">
                     <span class="material-icons text-4xl text-primary mb-2">description</span>
                     <h4 class="font-semibold text-text-light dark:text-text-dark">PPWP</h4>
                     <p class="text-xs text-text-secondary-light dark:text-text-secondary-dark mb-3">Dokumen PPWP</p>
                     <button class="w-full bg-primary/10 text-primary hover:bg-primary/20 font-medium py-2 px-4 rounded-lg text-sm transition duration-150 ease-in-out">Lihat Dokumen</button>
                  </div>
                  <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg flex flex-col items-center text-center">
                     <span class="material-icons text-4xl text-primary mb-2">description</span>
                     <h4 class="font-semibold text-text-light dark:text-text-dark">DPR RI</h4>
                     <p class="text-xs text-text-secondary-light dark:text-text-secondary-dark mb-3">Dokumen DPR RI</p>
                     <button class="w-full bg-primary/10 text-primary hover:bg-primary/20 font-medium py-2 px-4 rounded-lg text-sm transition duration-150 ease-in-out">Lihat Dokumen</button>
                  </div>
                  <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg flex flex-col items-center text-center">
                     <span class="material-icons text-4xl text-primary mb-2">description</span>
                     <h4 class="font-semibold text-text-light dark:text-text-dark">DPD</h4>
                     <p class="text-xs text-text-secondary-light dark:text-text-secondary-dark mb-3">Dokumen DPD</p>
                     <button class="w-full bg-primary/10 text-primary hover:bg-primary/20 font-medium py-2 px-4 rounded-lg text-sm transition duration-150 ease-in-out">Lihat Dokumen</button>
                  </div>
                  <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg flex flex-col items-center text-center">
                     <span class="material-icons text-4xl text-primary mb-2">description</span>
                     <h4 class="font-semibold text-text-light dark:text-text-dark">DPRD Prov</h4>
                     <p class="text-xs text-text-secondary-light dark:text-text-secondary-dark mb-3">Dokumen DPRD Prov</p>
                     <button class="w-full bg-primary/10 text-primary hover:bg-primary/20 font-medium py-2 px-4 rounded-lg text-sm transition duration-150 ease-in-out">Lihat Dokumen</button>
                  </div>
                  <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg flex flex-col items-center text-center">
                     <span class="material-icons text-4xl text-primary mb-2">description</span>
                     <h4 class="font-semibold text-text-light dark:text-text-dark">DPRD Kab</h4>
                     <p class="text-xs text-text-secondary-light dark:text-text-secondary-dark mb-3">Dokumen DPRD Kab</p>
                     <button class="w-full bg-primary/10 text-primary hover:bg-primary/20 font-medium py-2 px-4 rounded-lg text-sm transition duration-150 ease-in-out">Lihat Dokumen</button>
                  </div>
               </div>
            </div>
            {{-- anggota kpps --}}
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-3">
               <div>
                  <h3 class="text-xl font-bold">Anggota KPPS</h3>
                  <p class="text-sm text-gray-500">Daftar semua anggota KPPS di TPS ini.</p>
               </div>
               <button
                  data-modal-target="crud-modal"
                  data-modal-toggle="crud-modal"
                  class="flex items-center justify-center space-x-2 bg-primary hover:bg-primary/90 text-white font-medium py-2 px-4 rounded-lg text-sm transition"
                  >
               <span class="material-icons text-base">add</span>
               <span>Tambah Anggota</span>
               </button>
            </div>
            <div class="overflow-x-auto">
               <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                  <thead class="bg-gray-50 dark:bg-gray-700/50">
                     <tr>
                        <th class="px-4 py-3 text-left font-bold uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left font-bold uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-3 text-left font-bold uppercase tracking-wider">Jabatan</th>
                        <th class="px-4 py-3 text-left font-bold uppercase tracking-wider">Aksi</th>
                     </tr>
                  </thead>
                  <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                     @forelse ($anggota as $i => $p)
                     <tr>
                        <td class="px-4 py-2">{{ $i + 1 }}</td>
                        <td class="px-4 py-2">{{ $p->name }}</td>
                        <td class="px-4 py-2">{{ $p->job_title }}</td>
                        <td class="px-4 py-2 text-primary hover:text-primary/80"><a href="#">Edit</a></td>
                     </tr>
                     @empty
                     <tr>
                        <td colspan="4" class="text-center text-gray-500 py-3">Belum ada anggota KPPS</td>
                     </tr>
                     @endforelse
                  </tbody>
               </table>
            </div>
            <!-- Modal form tambah anggota KPPS -->
            <div id="crud-modal" tabindex="-1" aria-hidden="true"
              class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden">
              
              <!-- Overlay (gelap di belakang modal) -->
              <div class="fixed inset-0 bg-black/30 backdrop-blur-sm"></div>
              
              <!-- Modal content -->
              <div class="relative z-10 w-full max-w-md p-4">
                <div class="bg-white rounded-lg shadow-lg dark:bg-gray-700">
                  
                  <!-- Modal header -->
                  <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-600 rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                      Tambah Anggota KPPS
                    </h3>
                    <button type="button"
                      class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                      data-modal-hide="crud-modal">
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                      </svg>
                      <span class="sr-only">Close modal</span>
                    </button>
                  </div>

                  <!-- Modal body -->
                  <form action="{{ route('kpps.anggota.store', $tps->id) }}" method="POST" class="p-4 md:p-5">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                      <div class="col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                        <input type="text" name="name" id="name"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 
                          focus:border-primary-600 block w-full p-2.5"
                          placeholder="Nama anggota" required>
                      </div>
                      <div class="col-span-2">
                        <label for="job_title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                        <select name="job_title" id="job_title"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                          focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                          <option value="">-- Pilih --</option>
                          <option value="KPPS 2">KPPS 2</option>
                          <option value="KPPS 3">KPPS 3</option>
                          <option value="KPPS 4">KPPS 4</option>
                          <option value="KPPS 5">KPPS 5</option>
                          <option value="KPPS 6">KPPS 6</option>
                          <option value="KPPS 7">KPPS 7</option>
                          <option value="Keamanan">Keamanan</option>
                        </select>
                      </div>
                    </div>
                    <button type="submit"
                      class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 
                      focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                      <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                          d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                          clip-rule="evenodd"></path>
                      </svg>
                      Tambah
                    </button>
                  </form>
                </div>
              </div>
            </div>

            <!-- Script dropdown & burger -->
            <script>
               const userMenuBtn = document.getElementById("userMenuButton");
               const userDropdown = document.getElementById("profileDropdown");
               const burgerBtn = document.getElementById("burgerButton");
               const mobileMenu = document.getElementById("mobileMenu");
               
               if (userMenuBtn) {
               userMenuBtn.addEventListener("click", () => {
                   userDropdown.classList.toggle("hidden");
               });
               
               window.addEventListener("click", (e) => {
                   if (!userMenuBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                   userDropdown.classList.add("hidden");
                   }
               });
               }
               
               burgerBtn.addEventListener("click", () => {
               mobileMenu.classList.toggle("hidden");
               });
            </script>
         </section>
      </div>
   </div>
   </div>
      </main>
      {{-- FOOTER --}}
      <footer class="bg-card-light dark:bg-card-dark mt-12">
         <div class="container mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-text-secondary-light dark:text-text-secondary-dark">
               © 2023 PemiluApp. All rights reserved.
            </p>
         </div>
      </footer>
   </body>
</html>