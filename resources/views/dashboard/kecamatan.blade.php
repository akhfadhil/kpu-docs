<x-layout>

   <!-- Title header -->
   <x-slot:title>{{ $title }}</x-slot:title>

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