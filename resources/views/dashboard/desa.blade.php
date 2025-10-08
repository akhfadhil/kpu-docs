<x-layout>

   <!-- Title header -->
   <x-slot:title>{{ $title }}</x-slot:title>

   <!-- Konten Utama -->
   <section class="container mx-auto p-6" x-show="show" x-transition.duration.700ms>
      <!-- Breadcrumb -->
      <nav class="text-sm mb-6">
         <ol class="flex flex-wrap text-gray-600">
            <li><a href="/" class="hover:text-blue-600">Provinsi Jawa Timur</a></li>
            <li class="mx-2">></li>
            <li><a href="#" class="hover:text-blue-600">Banyuwangi</a></li>
            <li class="mx-2">></li>
            <li><a href="#" class="hover:text-blue-600">Kecamatan {{ $desa->kecamatan->name }}</a></li>
            <li class="mx-2">></li>
            <li class="text-gray-800 font-semibold">Desa {{ $desa->name }}</li>
         </ol>
      </nav>
      <!-- Daftar TPS -->
      <div class="bg-white shadow-lg rounded-2xl p-6">
         <h2 class="text-xl font-semibold mb-4">Daftar TPS di Desa {{ $desa->name }}</h2>
         <ul class="space-y-4">
            <!-- TPS 1 -->
            @foreach ($desa->tps as $tps)
            <li class="flex items-center justify-between border-b pb-3">
               <div>
                  <p class="font-semibold">{{ $tps->tps_code }}</p>
                  <p class="text-sm text-gray-600">{{ $tps->address }}</p>
               </div>
               <a href="/tps/{{ $tps->id }}" 
                  class="bg-blue-600 hover:bg-blue-700 active:scale-95 transform transition duration-200 text-white font-semibold px-4 py-2 rounded-xl shadow">
               Lihat Dokumen
               </a>
            </li>
            @endforeach
         </ul>
      </div>
   </section>
   
</x-layout>