<x-layout>

    <!-- Title header -->
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-page-header :title="'Kecamatan ' . $kecamatan->name" />

    <section class="container mx-auto p-6">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Provinsi Jawa Timur', 'url' => '/'],
            ['label' => 'Kabupaten Banyuwangi', 'url' => '#'],
            ['label' => 'Kecamatan ' . $kecamatan->name, 'url' => '#'],
        ]" />

        <!-- Main Content -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 space-y-8">

            {{-- Dokumen D Hasil Kecamatan --}}
            <section>
                <h3 class="text-xl font-bold text-text-light dark:text-text-dark mb-4">Dokumen D Hasil</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    @php
                        $docs = [
                            'PPWP' => 'ppwp.pdf',
                            'DPR RI' => 'dpr_ri.pdf',
                            'DPD' => 'dpd.pdf',
                            'DPRD Prov' => 'dprd_prov.pdf',
                            'DPRD Kab' => 'dprd_kab.pdf',
                        ];
                        $kecamatan_name = $kecamatan->name ?? 'kecamatan';
                    @endphp

                    @foreach ($docs as $title => $filename)
                        @php
                            $path = "documents/$kecamatan_name/D Hasil {$kecamatan_name}/$filename";
                            $exists = file_exists(public_path($path));
                        @endphp

                        <div
                            class="bg-gray-50 dark:bg-gray-700/40 rounded-xl p-5 flex flex-col items-center text-center shadow-sm hover:shadow-md transition">
                            <span class="material-icons text-4xl text-primary mb-2">description</span>
                            <h4 class="font-semibold text-text-light dark:text-text-dark">{{ $title }}</h4>
                            <p class="text-xs text-text-secondary-light dark:text-text-secondary-dark mb-3">Dokumen
                                {{ $title }}</p>

                            @if ($exists)
                                <button data-modal-target="pdfModal" data-modal-toggle="pdfModal"
                                    data-pdf="{{ asset($path) }}"
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
            </section>

            {{-- MODAL PDF --}}
            <div id="pdfModal" tabindex="-1" aria-hidden="true"
                class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/40 transition-opacity duration-300">
                <div class="relative w-full max-w-5xl mx-4 sm:mx-auto transform transition-all scale-95 opacity-0"
                    id="pdfModalContainer">
                    <!-- Kontainer Modal -->
                    <div
                        class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                        <!-- Header -->
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

                        <!-- Body -->
                        <div class="bg-gray-50 dark:bg-gray-800">
                            <iframe id="pdfFrame" src=""
                                class="w-full h-[80vh] sm:h-[75vh] border-0 rounded-b-2xl"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.querySelectorAll('.pdf-view-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const pdfUrl = btn.getAttribute('data-pdf');
                        const modal = document.getElementById('pdfModal');
                        const container = document.getElementById('pdfModalContainer');
                        const frame = document.getElementById('pdfFrame');

                        // Set source PDF
                        frame.src = pdfUrl;

                        // Tampilkan modal dengan animasi fade-in
                        modal.classList.remove('hidden');
                        setTimeout(() => {
                            container.classList.remove('opacity-0', 'scale-95');
                            container.classList.add('opacity-100', 'scale-100');
                        }, 10);
                    });
                });

                // Tutup modal saat klik luar atau tombol close
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
                        frame.src = ''; // kosongkan agar tidak tetap memuat
                    }, 200);
                }

                // Tutup modal saat klik di luar konten
                document.getElementById('pdfModal').addEventListener('click', (e) => {
                    if (e.target.id === 'pdfModal') closeModal();
                });
            </script>

            {{-- Daftar Desa --}}
            <section class="border-t pt-6">
                <h2 class="text-xl font-bold mb-4 text-text-light dark:text-text-dark">
                    Daftar Desa & Kelurahan di Kecamatan {{ $kecamatan->name }}
                </h2>
                <ul class="space-y-3">
                    @foreach ($kecamatan->desa as $desa)
                        <li
                            class="flex items-center justify-between bg-gray-50 dark:bg-gray-700/50 rounded-xl p-3 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <span class="font-medium text-text-light dark:text-text-dark">{{ $desa->name }}</span>
                            <a href="/desa/{{ $desa->id }}"
                                class="bg-primary hover:bg-primary/90 active:scale-95 transform transition duration-200 text-white font-semibold px-4 py-2 rounded-lg shadow">
                                Daftar TPS
                            </a>
                        </li>
                    @endforeach
                </ul>
            </section>

            {{-- Anggota PPK --}}
            <section class="border-t pt-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-text-light dark:text-text-dark">Anggota PPK</h3>
                        <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark mt-1">
                            Daftar semua anggota PPK di Desa ini, termasuk nama dan jabatannya.
                        </p>
                    </div>
                    {{-- Tombol Modal Tambah Anggota --}}
                    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                        class="flex items-center space-x-2 bg-primary hover:bg-primary/90 text-white font-medium py-2 px-4 rounded-lg text-sm transition">
                        <span class="material-icons text-base">add</span>
                        <span>Tambah Anggota</span>
                    </button>
                </div>

                {{-- Modal Form --}}
                <div id="crud-modal" tabindex="-1" aria-hidden="true"
                    class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black/40 backdrop-blur-sm">
                    <div class="bg-white dark:bg-gray-700 rounded-xl shadow-lg w-full max-w-md">
                        <div class="flex justify-between items-center border-b p-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Anggota PPK</h3>
                            <button type="button" data-modal-toggle="crud-modal"
                                class="text-gray-500 hover:text-gray-800 dark:hover:text-gray-300">
                                ✕
                            </button>
                        </div>
                        <form action="{{ route('ppk.store', $kecamatan->id) }}" method="POST" class="p-5 space-y-4">
                            @csrf
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium">Nama</label>
                                <input type="text" name="name" id="name"
                                    class="w-full p-2 border rounded-lg bg-gray-50 focus:ring-primary focus:border-primary text-gray-900"
                                    placeholder="Nama anggota" required>
                            </div>
                            <div>
                                <label for="job_title" class="block mb-2 text-sm font-medium">Jabatan</label>
                                <select name="job_title" id="job_title"
                                    class="w-full p-2 border rounded-lg bg-gray-50 focus:ring-primary focus:border-primary text-gray-900">
                                    <option value="">-- Pilih --</option>
                                    <option value="PPK 2">PPK 2</option>
                                    <option value="PPK 3">PPK 3</option>
                                    <option value="PPK 4">PPK 4</option>
                                    <option value="PPK 5">PPK 5</option>
                                </select>
                            </div>
                            <button type="submit"
                                class="w-full text-white bg-primary hover:bg-primary/90 rounded-lg py-2.5 font-medium flex items-center justify-center gap-2">
                                <span class="material-icons text-sm">add</span>
                                Tambah
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Tabel Anggota --}}
                <div class="overflow-x-auto mt-4">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Jabatan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            @forelse ($anggota as $i => $p)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-6 py-4 text-sm">{{ $i + 1 }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $p->name }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $p->job_title }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <!-- Tombol Edit -->
                                            <button
                                                class="edit-btn bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-sm"
                                                data-id="{{ $p->id }}" data-name="{{ $p->name }}"
                                                data-job="{{ $p->job_title }}" data-modal-target="editPPKModal"
                                                data-modal-toggle="editPPKModal">
                                                Edit
                                            </button>


                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('ppk.anggota.destroy', $p->id) }}" data-confirm
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-md text-sm font-medium transition duration-150">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Modal Edit PPK -->
                                        <div id="editPPKModal" tabindex="-1" aria-hidden="true"
                                            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                                            <div
                                                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
                                                <h3
                                                    class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">
                                                    Edit Anggota PPK</h3>

                                                <form id="editPPKForm" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mb-4">
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama</label>
                                                        <input type="text" name="name" id="editName"
                                                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md focus:ring-primary focus:border-primary">
                                                    </div>

                                                    <div class="mb-4">
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jabatan</label>
                                                        <select name="job_title" id="editJobTitle"
                                                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md focus:ring-primary focus:border-primary">
                                                            <option value="">-- Pilih --</option>
                                                            <option value="PPK 1">PPK 1</option>
                                                            <option value="PPK 2">PPK 2</option>
                                                            <option value="PPK 3">PPK 3</option>
                                                            <option value="PPK 4">PPK 4</option>
                                                            <option value="PPK 5">PPK 5</option>

                                                        </select>
                                                    </div>

                                                    <div class="flex justify-end space-x-2">
                                                        <button type="button" data-modal-hide="editPPKModal"
                                                            class="px-4 py-2 rounded-md bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600">
                                                            Batal
                                                        </button>
                                                        <button type="submit"
                                                            class="px-4 py-2 rounded-md bg-primary text-white hover:bg-primary/80">
                                                            Simpan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada anggota
                                        PPK
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

        </div>

    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- EDIT MODAL & ACTION FORM --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editButtons = document.querySelectorAll('.edit-btn');
            const form = document.getElementById('editPPKForm');
            const nameInput = document.getElementById('editName');
            const jobInput = document.getElementById('editJobTitle');

            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.dataset.id;
                    const name = button.dataset.name;
                    const job = button.dataset.job;

                    // Isi data ke modal
                    nameInput.value = name;
                    jobInput.value = job;

                    // Ganti action form ke route update
                    form.action = `/ppk/${id}`;
                });
            });
        });
    </script>

    {{-- DELETE CONFIRM --}}
    <script>
        document.querySelectorAll('form[data-confirm]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus anggota?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</x-layout>
