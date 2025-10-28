<x-layout>

    <!-- Title header -->
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-page-header :title="'Desa ' . $desa->name" />

    <!-- Konten Utama -->
    <section class="container mx-auto p-6" x-show="show" x-transition.duration.700ms>
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Provinsi Jawa Timur', 'url' => '/'],
            ['label' => 'Kabupaten Banyuwangi', 'url' => '#'],
            ['label' => 'Kecamatan ' . $desa->kecamatan->name, 'url' => '#'],
            ['label' => 'Desa ' . $desa->name, 'url' => null],
        ]" />

        <!-- Main Content -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 space-y-8">

            {{-- Daftar TPS --}}
            <section>
                <h2 class="text-xl font-bold text-text-light dark:text-text-dark mb-4 border-b pb-2">
                    Daftar TPS di Desa {{ $desa->name }}
                </h2>
                <ul class="space-y-3">
                    @foreach ($desa->tps as $tps)
                        <li
                            class="flex items-center justify-between bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <div>
                                <p class="font-semibold text-text-light dark:text-text-dark">{{ $tps->tps_code }}</p>
                                <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark">
                                    {{ $tps->address }}</p>
                            </div>
                            <a href="/tps/{{ $tps->id }}"
                                class="bg-primary hover:bg-primary/90 active:scale-95 transform transition duration-200 text-white font-semibold px-4 py-2 rounded-lg shadow">
                                Lihat Dokumen
                            </a>
                        </li>
                    @endforeach
                </ul>
            </section>

            {{-- Anggota PPS --}}
            <section class="border-t pt-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-text-light dark:text-text-dark">Anggota PPS</h3>
                        <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark mt-1">
                            Daftar semua anggota PPS di Desa ini, termasuk nama dan jabatannya.
                        </p>
                    </div>
                    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                        class="flex items-center space-x-2 bg-primary hover:bg-primary/90 text-white font-medium py-2 px-4 rounded-lg text-sm transition">
                        <span class="material-icons text-base">add</span>
                        <span>Tambah Anggota</span>
                    </button>
                </div>

                {{-- Modal Form Tambah Anggota PPS --}}
                <div id="crud-modal" tabindex="-1" aria-hidden="true"
                    class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black/40 backdrop-blur-sm">
                    <div class="bg-white dark:bg-gray-700 rounded-xl shadow-lg w-full max-w-md">
                        <div class="flex justify-between items-center border-b p-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Anggota PPS</h3>
                            <button type="button" data-modal-toggle="crud-modal"
                                class="text-gray-500 hover:text-gray-800 dark:hover:text-gray-300">✕</button>
                        </div>
                        <form action="{{ route('pps.store', $desa->id) }}" method="POST" class="p-5 space-y-4">
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
                                    <option value="PPS 2">PPS 2</option>
                                    <option value="PPS 3">PPS 3</option>
                                </select>
                            </div>
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 text-white bg-primary hover:bg-primary/90 rounded-lg py-2.5 font-medium">
                                <span class="material-icons text-sm">add</span>
                                Tambah
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Tabel Anggota PPS --}}
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
                                                data-job="{{ $p->job_title }}" data-modal-target="editPPSModal"
                                                data-modal-toggle="editPPSModal">
                                                Edit
                                            </button>


                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('pps.anggota.destroy', $p->id) }}" data-confirm
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

                                        <!-- Modal Edit PPS -->
                                        <div id="editPPSModal" tabindex="-1" aria-hidden="true"
                                            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                                            <div
                                                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
                                                <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">
                                                    Edit Anggota PPS</h3>

                                                <form id="editPPSForm" method="POST">
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
                                                            <option value="PPS 1">PPS 1</option>
                                                            <option value="PPS 2">PPS 2</option>
                                                            <option value="PPS 3">PPS 3</option>
                                                        </select>
                                                    </div>

                                                    <div class="flex justify-end space-x-2">
                                                        <button type="button" data-modal-hide="editPPSModal"
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
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada anggota PPS
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
            const form = document.getElementById('editPPSForm');
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
                    form.action = `/pps/${id}`;
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
