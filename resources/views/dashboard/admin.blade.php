<x-layout>

    <!-- Title header -->
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-page-header title="Dashboard Admin" />

    <!-- Bagian Pencarian -->
    <section class="container mx-auto p-6" x-show="show" x-transition.duration.700ms>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Bagian Pencarian -->
            <section id="search-section"
                class="bg-white shadow-lg rounded-2xl p-6 col-span-2 transform transition duration-500 hover:scale-[1.02] hover:shadow-xl">
                {{-- dokumen --}}
                <h3 class="text-xl font-bold text-text-light dark:text-text-dark mb-4">Dokumen D Hasil Kabupaten</h3>
                <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg flex flex-col items-center text-center">
                        <span class="material-icons text-4xl text-primary mb-2">description</span>
                        <h4 class="font-semibold text-text-light dark:text-text-dark">PPWP</h4>
                        <p class="text-xs text-text-secondary-light dark:text-text-secondary-dark mb-3">D Hasil
                            Kabupaten</p>
                        <button
                            class="w-full bg-primary/10 text-primary hover:bg-primary/20 font-medium py-2 px-4 rounded-lg text-sm transition duration-150 ease-in-out">Lihat
                            Dokumen</button>
                    </div>
                </div>
                <h2 class="text-xl font-semibold mb-4">Pencarian Berdasarkan Wilayah</h2>
                <form action="/hasil" method="get" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Provinsi -->
                    <div>
                        <label for="provinsi" class="block text-sm font-medium mb-1">Provinsi</label>
                        <input type="text" id="provinsi" name="provinsi" value="Jawa Timur" readonly
                            class="w-full border rounded-lg p-2 bg-gray-100 text-gray-700 cursor-not-allowed">
                    </div>
                    <!-- Kabupaten -->
                    <div>
                        <label for="kabupaten" class="block text-sm font-medium mb-1">Kabupaten</label>
                        <input type="text" id="kabupaten" name="kabupaten" value="Banyuwangi" readonly
                            class="w-full border rounded-lg p-2 bg-gray-100 text-gray-700 cursor-not-allowed">
                    </div>
                    <!-- Kecamatan -->
                    <div>
                        <label for="kecamatan" class="block text-sm font-medium mb-1">Kecamatan</label>
                        <select id="kecamatan" name="kecamatan" required
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach ($kecamatan as $kcmt)
                                <option value="{{ $kcmt['id'] }}">{{ $kcmt['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Desa -->
                    <div>
                        <label for="desa" class="block text-sm font-medium mb-1">Desa</label>
                        <select id="desa" name="desa" required
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Desa --</option>
                        </select>
                    </div>
                    <!-- Tombol Cari -->
                    <div class="md:col-span-2 flex justify-end mt-4">
                        <button type="button" id="btnCari"
                            class="bg-blue-600 hover:bg-blue-700 active:scale-95 transform transition duration-200 text-white font-semibold px-6 py-2 rounded-xl shadow">
                            Cari
                        </button>
                    </div>
                </form>
            </section>
            <!-- Bagian Informasi Singkat -->
            <section id="info-section"
                class="bg-white shadow-lg rounded-2xl p-6 transform transition duration-500 hover:scale-[1.02] hover:shadow-xl">
                <h2 class="text-xl font-semibold mb-4">Informasi Singkat</h2>
                <ul class="space-y-2">
                    <li class="flex justify-between border-b pb-2">
                        <span>Total TPS</span>
                        <strong>12.345</strong>
                    </li>
                    <li class="flex justify-between border-b pb-2">
                        <span>Jumlah Dokumen</span>
                        <strong>8.765</strong>
                    </li>
                    <li class="flex justify-between">
                        <span>Pengumuman</span>
                        <strong class="text-blue-600">Pengumpulan dokumen C1 berakhir 20 Agustus</strong>
                    </li>
                </ul>
            </section>
        </div>
    </section>

    <!-- Script dropdown desa -->
    <script>
        document.getElementById('kecamatan').addEventListener('change', function() {
            const kecamatanId = this.value;
            const desaDropdown = document.getElementById('desa');

            // Reset dropdown desa
            desaDropdown.innerHTML = '<option value="">-- Pilih Desa --</option>';

            if (kecamatanId) {
                fetch(`/get-desa-by-kecamatan/${kecamatanId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        data.forEach(desa => {
                            const option = document.createElement('option');
                            option.value = desa.id; // Assuming your desa table has id_desa
                            option.textContent = desa.name; // Assuming your desa table has nama_desa
                            desaDropdown.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching villages:', error));
            }
        });
    </script>

    <!-- Script untuk redirect -->
    <script>
        document.getElementById('btnCari').addEventListener('click', function() {
            const kecamatanId = document.getElementById('kecamatan').value;
            const desaId = document.getElementById('desa').value;

            // Check if a village is selected
            if (desaId) {
                // Redirect to the Laravel route
                window.location.href = `/desa/${desaId}`;
            } else {
                // Alert the user if no village is selected
                window.location.href = `/kecamatan/${kecamatanId}`;

            }
        });
    </script>

</x-layout>
