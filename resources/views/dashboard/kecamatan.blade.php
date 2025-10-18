<x-layout>

   <!-- Title header -->
   <x-slot:title>{{ $title }}</x-slot:title>
   <div class="bg-gray-800 dark:bg-gray-900 shadow-inner">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
         <h1 class="text-3xl font-bold text-white">Kecamatan {{ $kecamatan->name }}</h1>
      </div>
   </div>
  <section class="container mx-auto p-6">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-6">
      <ol class="flex flex-wrap text-gray-600">
        <li><a href="/" class="hover:text-blue-600">Provinsi Jawa Timur</a></li>
        <li class="mx-2">></li>
        <li><a href="#" class="hover:text-blue-600">Kabupaten Banyuwangi</a></li>
        <li class="mx-2">></li>
        <li><a href="#" class="hover:text-blue-600">Kecamatan {{ $kecamatan->name }}</a></li>
      </ol>
    </nav>


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
      </div>
    </div>
    <!-- Daftar Desa -->
    <div class="bg-white shadow-lg rounded-2xl p-6">
        <h2 class="text-xl font-semibold mb-4">Daftar Desa & Kelurahan di Kecamatan {{ $kecamatan->name }}</h2>
        <ul class="space-y-4">
        <!-- Desa -->
        @foreach ($kecamatan->desa as $desa)
        <li class="flex items-center justify-between border-b pb-3">
            <div>
                <p class="font-semibold">{{ $desa->name }}</p>
                <!-- <p class="text-sm text-gray-600">{{ $desa->name }}</p> -->
            </div>
            <a href="/desa/{{ $desa->id }}" 
                class="bg-blue-600 hover:bg-blue-700 active:scale-95 transform transition duration-200 text-white font-semibold px-4 py-2 rounded-xl shadow">
            Daftar TPS
            </a>
        </li>
        @endforeach
        </ul>
    </div>
  </section>
</x-layout>