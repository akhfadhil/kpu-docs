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
        <li><a href="#" class="hover:text-blue-600">Kecamatan {{ $tps->desa->kecamatan->name }}</a></li>
        <li class="mx-2">></li>
        <li><a href="{{ route('desa.index', $tps->desa->id) }}" class="hover:text-blue-600">Desa {{ $tps->desa->name }}</a></li>
        <li class="mx-2">></li>
        <li class="text-gray-800 font-semibold">{{ $tps->tps_code }}</li>
      </ol>
    </nav>

    <!-- Detail TPS -->
    <div class="bg-white shadow-lg rounded-2xl p-6">
      <h2 class="text-xl font-semibold mb-4">Detail TPS {{ $tps->tps_code}}</h2>

      <div class="space-y-2">
        <div class="grid grid-cols-3 gap-2">
          <span class="font-semibold">Alamat</span>
          <span class="col-span-2">: {{ $tps->address }}</span>
        </div>
        <div class="grid grid-cols-3 gap-2">
          <span class="font-semibold">Jumlah Pemilih</span>
          <span class="col-span-2">: {{ $tps->number_of_voters }}</span>
        </div>
        <div class="grid grid-cols-3 gap-2">
          <span class="font-semibold">Petugas KPPS</span>
          <span class="col-span-2">: {{ $tps->ketua_kpps->name }}</span>
          {{-- ambil semua kpps member $tps->kpps_members->pluck('name'); --}}
        </div>
      </div>
      
      
      <!-- {{-- Tabel KPPS --}} -->
        <div class="col-span-3">
          <table class="w-full text-sm border border-gray-300 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-1 border">No</th>
                <th class="px-4 py-2 border">Nama</th>
                <th class="px-4 py-2 border">Jabatan</th>
              </tr>
            </thead>
            <tbody>
              @php
                $petugas = [
                  ['nama' => 'Budi Santoso', 'jabatan' => 'Ketua'],
                  ['nama' => 'Siti Aminah', 'jabatan' => 'Anggota 1'],
                  ['nama' => 'Joko Prabowo', 'jabatan' => 'Anggota 2'],
                  ['nama' => 'Rina Wulandari', 'jabatan' => 'Anggota 3'],
                  ['nama' => 'Andi Wijaya', 'jabatan' => 'Anggota 4'],
                  ['nama' => 'Dewi Lestari', 'jabatan' => 'Anggota 5'],
                  ['nama' => 'Ahmad Fauzi', 'jabatan' => 'Anggota 6'],
                ];
              @endphp
              @foreach ($petugas as $i => $p)
                <tr class="hover:bg-gray-50">
                  <td class="px-4 py-2 border text-center">{{ $i+1 }}</td>
                  <td class="px-4 py-2 border">{{ $p['nama'] }}</td>
                  <td class="px-4 py-2 border">{{ $p['jabatan'] }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>


      <!-- Dokumen -->
      {{-- <div class="mt-6">
        <h3 class="text-lg font-semibold mb-2">Dokumen Hasil</h3>

        @if($tps->dokumen->count())
          <ul class="space-y-3">
            @foreach($tps->dokumen as $dok)
              <li class="flex items-center justify-between border-b pb-3">
                <div>
                  <p class="font-semibold">{{ $dok->jenis_dokumen_label }}</p>
                  <p class="text-sm text-gray-600">
                    Diupload pada {{ $dok->created_at->format('d M Y, H:i') }}
                  </p>
                </div>
                <button 
                    data-modal-target="pdfModal" 
                    data-modal-toggle="pdfModal"
                    data-pdf-url="{{ route('dokumen.view', $dok->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 active:scale-95 transform transition duration-200 text-white font-semibold px-4 py-2 rounded-xl shadow">
                    Lihat Dokumen
                </button>
              </li>
            @endforeach
          </ul>
        @else
          <p class="text-gray-500">Belum ada dokumen diunggah</p>
        @endif


      </div> --}}
    </div>
  </section>

  <!-- Modal -->
  <div id="pdfModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 
           justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Dokumen</h3>
          <button type="button" data-modal-hide="pdfModal"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 
                   rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center 
                   dark:hover:bg-gray-600 dark:hover:text-white">✕</button>
        </div>
        <!-- Body -->
        <div class="p-4">
          <iframe id="pdfFrame" src="" class="w-full h-[70vh] border rounded"></iframe>
        </div>
      </div>
    </div>
  </div>

  <script>
    // ketika tombol ditekan, ganti src iframe
    document.querySelectorAll("[data-modal-toggle='pdfModal']").forEach(button => {
      button.addEventListener("click", function() {
        const pdfUrl = this.getAttribute("data-pdf-url");
        document.getElementById("pdfFrame").src = pdfUrl;
      });
    });

    // kosongkan iframe saat modal ditutup
    document.querySelectorAll("[data-modal-hide='pdfModal']").forEach(button => {
      button.addEventListener("click", function() {
        document.getElementById("pdfFrame").src = "";
      });
    });
  </script>
</x-layout>