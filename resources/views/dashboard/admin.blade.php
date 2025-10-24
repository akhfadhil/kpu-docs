<x-layout>

    <!-- Title header -->
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-page-header title="Dashboard Admin" />

    <!-- Kontainer utama -->
    <section class="container mx-auto p-6 space-y-8" x-show="show" x-transition.duration.700ms>
        
        <!-- === BAGIAN DOKUMEN & PENCARIAN === -->
        <section id="search-section"
            class="bg-white shadow-lg rounded-2xl p-6 transition duration-500 hover:shadow-xl">
            
            <h3 class="text-xl font-bold text-text-light dark:text-text-dark mb-4">
                Dokumen D Hasil Kabupaten
            </h3>

            <!-- Grid daftar dokumen -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-6">
                @php
                    $docs = [
                        'PPWP' => 'ppwp.pdf',
                        'DPR RI' => 'dpr_ri.pdf',
                        'DPD' => 'dpd.pdf',
                        'DPRD Prov' => 'dprd_prov.pdf',
                        'DPRD Kab' => 'dprd_kab.pdf',
                    ];
                @endphp

                @foreach ($docs as $title => $filename)
                    @php
                        $relativePath = "documents/D Hasil Kabupaten/" . $filename;
                        $fullPath = public_path($relativePath);
                        $existing = file_exists($fullPath);
                    @endphp

                    <div
                        class="bg-gray-50 dark:bg-gray-700/40 rounded-xl p-5 flex flex-col items-center text-center shadow-sm hover:shadow-md transition">
                        <span class="material-icons text-4xl text-primary mb-2">description</span>
                        <h4 class="font-semibold text-text-light dark:text-text-dark">{{ $title }}</h4>

                        @if ($existing)
                            <button data-modal-target="pdfModal" data-modal-toggle="pdfModal"
                                data-pdf="{{ asset($relativePath) }}"
                                class="pdf-view-btn w-full bg-primary/10 text-primary hover:bg-primary/20 font-medium py-2 px-4 rounded-lg text-sm transition">
                                Lihat Dokumen
                            </button>
                        @else
                            <button disabled
                                class="w-full bg-gray-200 dark:bg-gray-600 text-gray-400 cursor-not-allowed font-medium py-2 px-4 rounded-lg text-sm">
                                Tidak Ada File
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- MODAL PDF --}}
            <div id="pdfModal" tabindex="-1" aria-hidden="true"
                class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/40 transition-opacity duration-300">
                <div class="relative w-full max-w-5xl mx-4 sm:mx-auto transform transition-all scale-95 opacity-0"
                    id="pdfModalContainer">
                    <div
                        class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div
                            class="flex items-center justify-between px-6 py-4 bg-gray-100 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                            <h3
                                class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white flex items-center space-x-2">
                                <span class="material-icons text-primary">picture_as_pdf</span>
                                <span>Pratinjau Dokumen D Hasil</span>
                            </h3>
                            <button type="button" data-modal-hide="pdfModal"
                                class="text-gray-500 hover:text-red-500 transition-colors duration-150 p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
                                <span class="material-icons text-lg">close</span>
                            </button>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-800">
                            <iframe id="pdfFrame" src=""
                                class="w-full h-[80vh] sm:h-[75vh] border-0 rounded-b-2xl"></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Buka modal PDF
                document.querySelectorAll('.pdf-view-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const pdfUrl = btn.getAttribute('data-pdf');
                        const modal = document.getElementById('pdfModal');
                        const container = document.getElementById('pdfModalContainer');
                        const frame = document.getElementById('pdfFrame');

                        frame.src = pdfUrl;
                        modal.classList.remove('hidden');

                        setTimeout(() => {
                            container.classList.remove('opacity-0', 'scale-95');
                            container.classList.add('opacity-100', 'scale-100');
                        }, 50);
                    });
                });

                // Tutup modal
                document.querySelectorAll('[data-modal-hide="pdfModal"]').forEach(btn => {
                    btn.addEventListener('click', closeModal);
                });

                function closeModal() {
                    const modal = document.getElementById('pdfModal');
                    const container = document.getElementById('pdfModalContainer');
                    const frame = document.getElementById('pdfFrame');

                    container.classList.add('opacity-0', 'scale-95');
                    container.classList.remove('opacity-100', 'scale-100');
                    setTimeout(() => {
                        modal.classList.add('hidden');
                        frame.src = '';
                    }, 200);
                }

                // Klik luar modal
                document.getElementById('pdfModal').addEventListener('click', (e) => {
                    if (e.target.id === 'pdfModal') closeModal();
                });
            </script>

            <!-- Form pencarian wilayah -->
            <h2 class="text-xl font-semibold mb-4 mt-8">Pencarian Berdasarkan Wilayah</h2>
            <form action="/hasil" method="get" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="provinsi" class="block text-sm font-medium mb-1">Provinsi</label>
                    <input type="text" id="provinsi" name="provinsi" value="Jawa Timur" readonly
                        class="w-full border rounded-lg p-2 bg-gray-100 text-gray-700 cursor-not-allowed">
                </div>
                <div>
                    <label for="kabupaten" class="block text-sm font-medium mb-1">Kabupaten</label>
                    <input type="text" id="kabupaten" name="kabupaten" value="Banyuwangi" readonly
                        class="w-full border rounded-lg p-2 bg-gray-100 text-gray-700 cursor-not-allowed">
                </div>
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
                <div>
                    <label for="desa" class="block text-sm font-medium mb-1">Desa</label>
                    <select id="desa" name="desa" required
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Desa --</option>
                    </select>
                </div>
                <div class="md:col-span-2 flex justify-end mt-4">
                    <button type="button" id="btnCari"
                        class="bg-blue-600 hover:bg-blue-700 active:scale-95 transform transition duration-200 text-white font-semibold px-6 py-2 rounded-xl shadow">
                        Cari
                    </button>
                </div>
            </form>
        </section>

        <!-- === BAGIAN INFORMASI SINGKAT === -->
        <section id="info-section"
            class="bg-white shadow-lg rounded-2xl p-6 transition duration-500 hover:shadow-xl">
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
    </section>

    <!-- Script dropdown desa -->
    <script>
        document.getElementById('kecamatan').addEventListener('change', function() {
            const kecamatanId = this.value;
            const desaDropdown = document.getElementById('desa');
            desaDropdown.innerHTML = '<option value="">-- Pilih Desa --</option>';

            if (kecamatanId) {
                fetch(`/get-desa-by-kecamatan/${kecamatanId}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        data.forEach(desa => {
                            const option = document.createElement('option');
                            option.value = desa.id;
                            option.textContent = desa.name;
                            desaDropdown.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching villages:', error));
            }
        });
    </script>

    <!-- Script redirect -->
    <script>
        document.getElementById('btnCari').addEventListener('click', function() {
            const kecamatanId = document.getElementById('kecamatan').value;
            const desaId = document.getElementById('desa').value;

            if (desaId) {
                window.location.href = `/desa/${desaId}`;
            } else if (kecamatanId) {
                window.location.href = `/kecamatan/${kecamatanId}`;
            } else {
                alert('Silakan pilih kecamatan terlebih dahulu.');
            }
        });
    </script>

</x-layout>
