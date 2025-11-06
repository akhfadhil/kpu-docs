<x-layout>

    <!-- Title header -->
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-page-header title="Dashboard Admin" />

    <!-- Kontainer utama -->
    <section class="container mx-auto p-6 space-y-8" x-show="show" x-transition.duration.700ms>

        <!-- === BAGIAN DOKUMEN & PENCARIAN === -->
        <section id="search-section"
            class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 
                    shadow-lg rounded-2xl p-6 transition duration-500 
                    hover:shadow-xl dark:hover:shadow-gray-900">

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
                        $relativePath = 'documents/D Hasil Kabupaten/' . $filename;
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
            <h2 class="text-xl font-semibold mb-4 mt-8 text-gray-900 dark:text-gray-100">
                Pencarian Berdasarkan Wilayah
            </h2>

            <form action="/hasil" method="get" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Provinsi -->
                <div>
                    <label for="provinsi" class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">
                        Provinsi
                    </label>
                    <input type="text" id="provinsi" name="provinsi" value="Jawa Timur" readonly
                        class="w-full border border-gray-300 dark:border-gray-700 
                   rounded-lg p-2 bg-gray-100 dark:bg-gray-700 
                   text-gray-800 dark:text-gray-200 cursor-not-allowed">
                </div>

                <!-- Kabupaten -->
                <div>
                    <label for="kabupaten" class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">
                        Kabupaten
                    </label>
                    <input type="text" id="kabupaten" name="kabupaten" value="Banyuwangi" readonly
                        class="w-full border border-gray-300 dark:border-gray-700 
                   rounded-lg p-2 bg-gray-100 dark:bg-gray-700 
                   text-gray-800 dark:text-gray-200 cursor-not-allowed">
                </div>

                <!-- Kecamatan -->
                <div>
                    <label for="kecamatan" class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">
                        Kecamatan
                    </label>
                    <select id="kecamatan" name="kecamatan" required
                        class="w-full border border-gray-300 dark:border-gray-700 
                   rounded-lg p-2 bg-white dark:bg-gray-700 
                   text-gray-800 dark:text-gray-200 
                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach ($kecamatan as $kcmt)
                            <option value="{{ $kcmt['id'] }}">{{ $kcmt['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Desa -->
                <div>
                    <label for="desa" class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">
                        Desa
                    </label>
                    <select id="desa" name="desa" required
                        class="w-full border border-gray-300 dark:border-gray-700 
                   rounded-lg p-2 bg-white dark:bg-gray-700 
                   text-gray-800 dark:text-gray-200 
                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Desa --</option>
                    </select>
                </div>

                <!-- Tombol -->
                <div class="col-span-1 sm:col-span-2 flex flex-col sm:flex-row sm:justify-end mt-4">
                    <button type="button" id="btnCari"
                        class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600
                        active:scale-95 transform transition duration-200
                        text-white font-semibold px-6 py-2 rounded-xl shadow text-center">
                        Cari
                    </button>
                </div>

            </form>

        </section>

        <!-- === BAGIAN PENGUMUMAN === -->
        <section id="info-announcement"
            class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100
           shadow-lg rounded-2xl p-6 transition duration-500
           hover:shadow-xl dark:hover:shadow-gray-900">
            <div class="flex flex-col md:flex-row md:space-x-6">
                <!-- Form Pengumuman -->
                <div class="md:w-1/2 flex flex-col">
                    <h2 class="text-lg font-semibold mb-2 text-gray-900 dark:text-gray-100">
                        Buat Pengumuman
                    </h2>

                    <form action="{{ route('admin.announcements.store') }}" method="POST" class="flex flex-col gap-3">
                        @csrf

                        <!-- Judul -->
                        <div>
                            <label class="block text-sm font-medium text-gray-800 dark:text-gray-200 mb-1">
                                Judul
                            </label>
                            <input type="text" name="title" required
                                class="w-full border border-gray-300 dark:border-gray-700 
                               p-2 rounded bg-gray-100 dark:bg-gray-700 
                               text-gray-800 dark:text-gray-100 
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Isi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-800 dark:text-gray-200 mb-1">
                                Isi Pengumuman
                            </label>
                            <textarea name="content" rows="3" required
                                class="w-full border border-gray-300 dark:border-gray-700 
                               p-2 rounded bg-gray-100 dark:bg-gray-700 
                               text-gray-800 dark:text-gray-100 
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-medium text-gray-800 dark:text-gray-200 mb-1">
                                Role Target
                            </label>
                            <select name="role" required
                                class="w-full border border-gray-300 dark:border-gray-700 
                               p-2 rounded bg-white dark:bg-gray-700 
                               text-gray-800 dark:text-gray-100 
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="ppk">PPK</option>
                                <option value="pps">PPS</option>
                                <option value="kpps">KPPS</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 
                           text-white px-4 py-2 rounded w-full md:w-auto
                           transition transform active:scale-95 shadow">
                            Simpan
                        </button>
                    </form>
                </div>

                <!-- Tabel Pengumuman -->
                <div class="md:w-1/2 mt-6 md:mt-0 flex flex-col">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Daftar Pengumuman
                        </h2>

                        <!-- Filter Role -->
                        <select id="announcementRoleFilter"
                            class="w-full sm:w-auto border border-gray-300 dark:border-gray-700 
                            px-3 py-2 rounded-lg text-sm 
                            bg-white dark:bg-gray-700 
                            text-gray-800 dark:text-gray-100 
                            focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="">Semua Role</option>
                            <option value="ppk">PPK</option>
                            <option value="pps">PPS</option>
                            <option value="kpps">KPPS</option>
                        </select>
                    </div>


                    <!-- Container flex untuk tabel -->
                    <div class="flex-1 overflow-y-auto border border-gray-300 dark:border-gray-700 rounded p-2">
                        <table class="w-full text-sm text-left text-gray-800 dark:text-gray-100 border-collapse"
                            id="announcementTable">
                            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <tr>
                                    <th class="border border-gray-300 dark:border-gray-600 px-2 py-1">Judul</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-2 py-1">Isi</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-2 py-1">Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($announcements as $a)
                                    <tr data-role="{{ $a->role }}"
                                        class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                        <td class="border border-gray-300 dark:border-gray-600 px-2 py-1">
                                            {{ $a->title }}</td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-2 py-1">
                                            {{ $a->content }}</td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-2 py-1">
                                            {{ strtoupper($a->role) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-2 text-gray-500 dark:text-gray-400">
                                            Belum ada pengumuman.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const roleFilter = document.getElementById('announcementRoleFilter');
                const tableRows = document.querySelectorAll('#announcementTable tbody tr');

                roleFilter.addEventListener('change', function() {
                    const selectedRole = this.value;
                    tableRows.forEach(row => {
                        const rowRole = row.getAttribute('data-role');
                        if (!selectedRole || rowRole === selectedRole) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            });
        </script>

        <!-- === BAGIAN INFORMASI SINGKAT === -->
        <section id="info-section"
            class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 
                    shadow-lg rounded-2xl p-6 transition duration-500 
                    hover:shadow-xl dark:hover:shadow-gray-900">
            <h2 class="text-xl font-semibold mb-4">Informasi Singkat</h2>
            <ul class="space-y-2">
                <li class="flex justify-between border-b pb-2">
                    <span>Total TPS</span>
                    <strong>{{ $jumlahTPS }}</strong>
                </li>
                <li class="flex justify-between border-b pb-2">
                    <span>Jumlah Dokumen</span>
                    <strong>{{ $jumlahDokumen }}</strong>
                </li>
            </ul>
        </section>

        <!-- === BAGIAN INFORMASI USER === -->
        <section id="user-section"
            class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 
        shadow-lg rounded-2xl p-6 transition duration-500 
        hover:shadow-xl dark:hover:shadow-gray-900">
            <!-- Header dan Filter -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
                <!-- Judul -->
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    Daftar Pengguna
                </h2>

                <!-- Filter Section -->
                <div class="flex flex-wrap items-center gap-3 sm:gap-4 md:gap-5 w-full md:w-auto">
                    <!-- Filter Role -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2 w-full sm:w-auto">
                        <label for="filterRole"
                            class="text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">
                            Filter Role:
                        </label>
                        <select id="filterRole"
                            class="w-full sm:w-auto border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm 
                            bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                            focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="">Semua</option>
                            <option value="admin">Admin</option>
                            <option value="ppk">PPK</option>
                            <option value="pps">PPS</option>
                        </select>
                    </div>

                    <!-- Filter Kecamatan -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2 w-full sm:w-auto">
                        <label for="filterWilayah"
                            class="text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">
                            Filter Kecamatan:
                        </label>
                        <select id="filterWilayah"
                            class="w-full sm:w-auto border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm 
                            bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                            focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                            <option value="">Semua Kecamatan</option>
                            @php
                                $kecamatanList = collect($users)
                                    ->map(function ($u) {
                                        if ($u->role->role === 'ppk' && $u->userable) {
                                            return $u->userable->kecamatan->name;
                                        } elseif ($u->role->role === 'pps' && $u->userable) {
                                            return $u->userable->desa->kecamatan->name;
                                        }
                                        return null;
                                    })
                                    ->filter()
                                    ->unique()
                                    ->sort();
                            @endphp

                            @foreach ($kecamatanList as $kec)
                                <option value="{{ strtolower($kec) }}">{{ $kec }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tombol Download PDF -->
                    <div class="w-full sm:w-auto">
                        <button id="downloadPdfBtn"
                            class="w-full sm:w-auto bg-red-500 hover:bg-red-600 active:scale-95 transform transition duration-200 
                            text-white px-5 py-2 rounded-lg text-sm font-medium shadow-sm">
                            Download PDF
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table id="userTable"
                    class="w-full text-sm text-left text-gray-700 dark:text-gray-200 border-collapse">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                        <tr>
                            <th class="px-4 py-2 border-b dark:border-gray-600">No</th>
                            <th class="px-4 py-2 border-b dark:border-gray-600">Nama</th>
                            <th class="px-4 py-2 border-b dark:border-gray-600">Username</th>
                            <th class="px-4 py-2 border-b dark:border-gray-600">Kecamatan</th>
                            <th class="px-4 py-2 border-b dark:border-gray-600">Role</th>
                            <th class="px-4 py-2 border-b dark:border-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @foreach ($users as $index => $u)
                            @php
                                $role = strtolower($u->role->role);
                                $kecamatan = '-';
                                if ($u->role->role === 'ppk' && $u->userable) {
                                    $kecamatan = $u->userable->kecamatan->name;
                                } elseif ($u->role->role === 'pps' && $u->userable) {
                                    $kecamatan = $u->userable->desa->kecamatan->name;
                                }
                            @endphp
                            <tr data-role="{{ $role }}" data-wilayah="{{ strtolower($kecamatan) }}"
                                data-temp="{{ $u->temporary_password ?? '-' }}"
                                class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="px-4 py-2 border-b dark:border-gray-600 text-center">{{ $index + 1 }}
                                </td>
                                <td class="px-4 py-2 border-b dark:border-gray-600">{{ $u->name }}</td>
                                <td class="px-4 py-2 border-b dark:border-gray-600">{{ $u->username }}</td>
                                <td class="px-4 py-2 border-b dark:border-gray-600">{{ $kecamatan }}</td>
                                <td class="px-4 py-2 border-b dark:border-gray-600">{{ strtoupper($u->role->role) }}
                                </td>
                                <td class="px-4 py-2 border-b dark:border-gray-600">
                                    <button data-modal-target="editUserModal" data-modal-toggle="editUserModal"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded 
                                       text-sm font-medium editUserBtn transition"
                                        data-id="{{ $u->id }}" data-name="{{ $u->name }}">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Modal Edit User -->
            <div id="editUserModal" tabindex="-1"
                class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">
                <div class="relative w-full max-w-md md:max-w-lg">
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden">
                        <!-- Header -->
                        <div
                            class="flex justify-between items-center p-5 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                Edit Nama User
                            </h3>
                            <button type="button" class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
                                data-modal-hide="editUserModal">
                                ✕
                            </button>
                        </div>

                        <!-- Form -->
                        <form id="editUserForm" method="POST" class="p-6 space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="editUserId">

                            <div>
                                <label for="editUserName"
                                    class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-300">
                                    Nama
                                </label>
                                <input type="text" name="name" id="editUserName" required
                                    class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded 
                                   bg-white dark:bg-gray-600 text-gray-900 dark:text-white
                                   focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded 
                                   w-full md:w-auto transition">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- JS untuk Filter dan Download PDF -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const roleFilter = document.getElementById('filterRole');
                const wilayahFilter = document.getElementById('filterWilayah');
                const rows = document.querySelectorAll('#userTableBody tr');

                function applyFilters() {
                    const selectedRole = roleFilter.value.toLowerCase();
                    const selectedWilayah = wilayahFilter.value.toLowerCase();

                    let visibleCount = 0;
                    rows.forEach(row => {
                        const rowRole = row.getAttribute('data-role');
                        const rowWilayah = row.getAttribute('data-wilayah');

                        const matchRole = !selectedRole || rowRole === selectedRole;
                        const matchWilayah = !selectedWilayah || rowWilayah.includes(selectedWilayah);

                        if (matchRole && matchWilayah) {
                            row.style.display = '';
                            visibleCount++;
                            row.querySelector('td').textContent = visibleCount; // update nomor urut
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }

                roleFilter.addEventListener('change', applyFilters);
                wilayahFilter.addEventListener('change', applyFilters);
            });
        </script>
        <script>
            document.getElementById('downloadPdfBtn').addEventListener('click', function() {
                const role = document.getElementById('filterRole').value;
                const kecamatan = document.getElementById('filterWilayah') ? document.getElementById('filterWilayah')
                    .value : '';
                let url = `{{ route('users.download.pdf') }}?role=${role}&kecamatan=${kecamatan}`;
                window.location.href = url;
            });
        </script>

        {{-- JS EDIT NAMA --}}
        <script>
            document.querySelectorAll('.editUserBtn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    document.getElementById('editUserId').value = id;
                    document.getElementById('editUserName').value = name;

                    // Update form action
                    const form = document.getElementById('editUserForm');
                    form.action = `/users/${id}`;
                });
            });
        </script>



    </section>

    <!-- === SCRIPT UNTUK FILTER DAN PAGINATION === -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const filterSelect = document.getElementById("filterRole");
            const rows = Array.from(document.querySelectorAll("#userTableBody tr"));
            const pagination = document.getElementById("pagination");
            const rowsPerPage = 25;
            let currentPage = 1;

            // Fungsi render tabel sesuai filter + pagination
            function renderTable() {
                const filter = filterSelect.value.toLowerCase();
                const filteredRows = rows.filter(row =>
                    !filter || row.dataset.role.includes(filter)
                );

                const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                rows.forEach(row => row.style.display = "none");
                filteredRows.slice(start, end).forEach(row => row.style.display = "");

                renderPagination(totalPages);
            }

            // Fungsi render pagination button
            function renderPagination(totalPages) {
                pagination.innerHTML = "";
                if (totalPages <= 1) return;

                for (let i = 1; i <= totalPages; i++) {
                    const btn = document.createElement("button");
                    btn.textContent = i;
                    btn.className =
                        "px-3 py-1 border rounded-md text-sm " +
                        (i === currentPage ?
                            "bg-blue-500 text-white border-blue-500" :
                            "bg-white text-gray-700 border-gray-300 hover:bg-gray-100");
                    btn.addEventListener("click", function() {
                        currentPage = i;
                        renderTable();
                        scrollToTableTop();
                    });
                    pagination.appendChild(btn);
                }
            }

            // Fungsi scroll ke atas tabel saat ganti halaman
            function scrollToTableTop() {
                document.getElementById("user-section").scrollIntoView({
                    behavior: "smooth"
                });
            }

            // Event saat filter diganti
            filterSelect.addEventListener("change", function() {
                currentPage = 1;
                renderTable();
            });

            // Render awal
            renderTable();
        });
    </script>

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
