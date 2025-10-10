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
          <span class="font-semibold">Ketua KPPS</span>
          <span class="col-span-2">: {{ $tps->ketua_kpps->name }}</span>
        </div>
      </div>
      
      <!-- Toast Success -->
      @if(session('success'))
          <div id="toast-success"
              class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 flex items-center w-full max-w-sm p-4 text-gray-500 bg-white rounded-lg shadow-lg opacity-0 transition-opacity duration-700 dark:text-gray-400 dark:bg-gray-800"
              role="alert">
              <div
                  class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                  <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                      viewBox="0 0 20 20">
                      <path
                          d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9 14.25a.75.75 0 0 1-1.06 0L4.97 11.28a.75.75 0 0 1 1.06-1.06L9 13.19l4.97-4.97a.75.75 0 0 1 1.06 1.06L9 14.25Z" />
                  </svg>
                  <span class="sr-only">Check icon</span>
              </div>
              <div class="ms-3 text-sm font-normal">
                  {{ session('success') }}
              </div>
              <button type="button"
                  class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                  onclick="closeToast()" aria-label="Close">
                  <span class="sr-only">Close</span>
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                      viewBox="0 0 14 14">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M1 1l12 12M13 1 1 13" />
                  </svg>
              </button>
          </div>

          <script>
              const toast = document.getElementById('toast-success');
              if (toast) {
                  // fade-in
                  setTimeout(() => {
                      toast.classList.remove('opacity-0');
                      toast.classList.add('opacity-100');
                  }, 100);

                  // fade-out lembut setelah 3 detik
                  setTimeout(() => {
                      toast.classList.remove('opacity-100');
                      toast.classList.add('opacity-0');
                      setTimeout(() => toast.remove(), 700);
                  }, 3000);
              }

              function closeToast() {
                  toast.classList.remove('opacity-100');
                  toast.classList.add('opacity-0');
                  setTimeout(() => toast.remove(), 700);
              }
          </script>
      @endif

      <!-- {{-- Tabel KPPS --}} -->
      <div class="bg-white p-6 rounded-lg">
        <div class="flex items-center justify-between mb-4">
          <div>
            <h2 class="text-lg font-semibold text-gray-900">Anggota KPPS</h2>
            <p class="text-sm text-gray-500">
              Daftar semua anggota KPPS di TPS ini, termasuk nama dan jabatannya.
            </p>
          </div>

          {{-- 🔹 Tombol ini buka modal dengan id="crud-modal" --}}
          <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 transition">
            Tambah Anggota
          </button>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full text-sm text-left text-gray-600">
            <thead class="text-xs uppercase bg-gray-50 text-gray-700 border-b">
              <tr>
                <th scope="col" class="px-4 py-2">No</th>
                <th scope="col" class="px-4 py-2">Nama</th>
                <th scope="col" class="px-4 py-2">Jabatan</th>
                <th scope="col" class="px-4 py-2 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($anggota as $i => $p)
                <tr class="bg-white border-b hover:bg-gray-50">
                  <td class="px-4 py-2 text-center">{{ $i + 1 }}</td>
                  <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">{{ $p->name }}</td>
                  <td class="px-4 py-2">{{ $p->job_title }}</td>
                  <td class="px-4 py-2 text-right">
                    <a href="#"
                      class="font-medium text-indigo-600 hover:text-indigo-800 text-sm">Edit</a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="px-4 py-2 text-center text-gray-500">
                    Belum ada anggota KPPS
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <!-- Modal body -->
      <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
          <!-- Overlay Blur -->
          <div class="fixed inset-0 bg-black/30 backdrop-blur-md transition-all duration-300"></div>

          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Tambah Anggota KPPS
              </h3>
              <button type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-toggle="crud-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 14">
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
                  <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Nama
                  </label>
                  <input type="text" name="name" id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                          focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                    placeholder="Nama anggota" required>
                </div>

                <div class="col-span-2">
                  <label for="job_title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Jabatan
                  </label>
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
                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none 
                      focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
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

  <!-- Modal PDF-->
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