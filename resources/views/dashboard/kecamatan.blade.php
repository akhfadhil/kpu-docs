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
                <h3 class="text-xl font-bold text-text-light dark:text-text-dark mb-4 border-b pb-2">
                    Dokumen D Hasil Kecamatan
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div
                        class="bg-gray-50 dark:bg-gray-700/50 p-5 rounded-xl flex flex-col items-center text-center shadow-sm hover:shadow-md transition">
                        <span class="material-icons text-4xl text-primary mb-2">description</span>
                        <h4 class="font-semibold text-text-light dark:text-text-dark">PPWP</h4>
                        <p class="text-xs text-text-secondary-light dark:text-text-secondary-dark mb-3">
                            D Hasil Kecamatan
                        </p>
                        <button
                            class="w-full bg-primary/10 text-primary hover:bg-primary/20 font-medium py-2 px-4 rounded-lg text-sm transition duration-150 ease-in-out">
                            Lihat Dokumen
                        </button>
                    </div>
                </div>
            </section>

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

            {{-- Anggota PPS --}}
            <section class="border-t pt-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-text-light dark:text-text-dark">Anggota PPS</h3>
                        <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark mt-1">
                            Daftar semua anggota PPS di Desa ini, termasuk nama dan jabatannya.
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
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Anggota PPS</h3>
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
                                        <a href="#" class="text-primary hover:underline">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada anggota PPK
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

        </div>

    </section>
</x-layout>
