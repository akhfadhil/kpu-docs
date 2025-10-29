<x-layout>

    <!-- Title header -->
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-page-header title="Dashboard Admin" />

    <!-- Kontainer utama -->
    <section class="container mx-auto p-6 space-y-8" x-show="show" x-transition.duration.700ms>

        <!-- === BAGIAN DOKUMEN & PENCARIAN === -->
        <section id="search-section" class="bg-white shadow-lg rounded-2xl p-6 transition duration-500 hover:shadow-xl">

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
        <section id="info-section" class="bg-white shadow-lg rounded-2xl p-6 transition duration-500 hover:shadow-xl">
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

        <!-- === SECTION USER TABLE === -->
        <section id="user-section"
            class="bg-white shadow-lg rounded-2xl p-6 mt-6 transition duration-500 hover:shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold">Daftar Pengguna</h2>

                <!-- Filter Dropdown -->
                <div class="flex items-center space-x-2">
                    <label for="filterRole" class="text-sm font-medium text-gray-600">Filter Role:</label>
                    <select id="filterRole"
                        class="border border-gray-300 rounded-lg px-2 py-1 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua</option>
                        <option value="admin">Admin</option>
                        <option value="ppk">PPK</option>
                        <option value="pps">PPS</option>
                    </select>
                </div>
            </div>

            <!-- Tabel User -->
            <div class="overflow-x-auto">
                <table id="userTable" class="w-full text-sm text-left text-gray-600 border border-gray-200 rounded-lg">
                    <thead class="text-gray-700 bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border-b">No</th>
                            <th class="px-4 py-2 border-b">Nama</th>
                            <th class="px-4 py-2 border-b">Username</th>
                            <th class="px-4 py-2 border-b">Wilayah</th>
                            <th class="px-4 py-2 border-b">Role</th>
                            <th class="px-4 py-2 border-b">Aksi</th>

                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @foreach ($users as $index => $u)
                            @php
                                $role = strtolower($u->role->role);
                                $roleColor = match ($role) {
                                    'admin' => 'text-red-600 bg-red-100',
                                    'ppk' => 'text-blue-600 bg-blue-100',
                                    'pps' => 'text-green-600 bg-green-100',
                                    default => 'text-gray-600 bg-gray-100',
                                };
                            @endphp
                            <tr class="hover:bg-gray-50" data-role="{{ $role }}">
                                <td class="px-4 py-2 border-b">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border-b">{{ $u->name }}</td>
                                <td class="px-4 py-2 border-b">{{ $u->username }}</td>
                                <td class="px-4 py-2 border-b">
                                    @if ($u->role->role === 'ppk' && $u->userable)
                                        {{ $u->userable->kecamatan->name }}
                                    @elseif ($u->role->role === 'pps' && $u->userable)
                                        {{ $u->userable->desa->name }} ({{ $u->userable->desa->kecamatan->name }})
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-2 border-b">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $roleColor }}">
                                        {{ strtoupper($u->role->role) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 border-b text-center">
                                    <!-- Tombol Edit -->
                                    <button data-modal-target="editModal-{{ $u->id }}"
                                        data-modal-toggle="editModal-{{ $u->id }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            <!-- Modal Edit -->
                            <div id="editModal-{{ $u->id }}" tabindex="-1"
                                class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-lg">
                                    <h3 class="text-lg font-semibold mb-4">Edit Nama User</h3>
                                    <form action="{{ route('users.update', $u->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-4">
                                            <label for="name"
                                                class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                                            <input type="text" name="name" value="{{ $u->name }}"
                                                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                                        </div>
                                        <div class="flex justify-end space-x-2">
                                            <button type="button" data-modal-hide="editModal-{{ $u->id }}"
                                                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md text-gray-700">Batal</button>
                                            <button type="submit"
                                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center items-center mt-4 space-x-2" id="pagination"></div>
        </section>



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
