<x-layout>

    <x-page-header :title="$tps->tps_code . ' ' .$tps->desa->name" />

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 mt-4 mb-4">
        {{-- breadcrumb --}}
        {{-- <x-breadcrumb :items="[
            ['label' => 'Provinsi Jawa Timur', 'url' => '#'],
            ['label' => 'Kabupaten Banyuwangi', 'url' => '#'],
            ['label' => 'Kecamatan ' . $tps->desa->kecamatan->name, 'url' => '#'],
            ['label' => 'Desa ' . $tps->desa->name, 'url' => '#'],
            ['label' => $tps->tps_code, 'url' => null],
        ]" /> --}}
<x-breadcrumb :items="$breadcrumb" />

        <!-- Main Content -->
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-6 sm:p-8 space-y-10">

                        {{-- Pengumuman Terbaru --}}
@if($announcement)
<section id="announcement-section" class="flex justify-center items-center mt-10">
    <div class="relative bg-gradient-to-r from-red-600 to-orange-500 shadow-2xl 
                rounded-2xl p-8 w-full max-w-2xl text-center">

        <!-- 🔔 Label di tengah -->
        <div class="absolute -top-4 inset-x-0 flex justify-center">
            <div class="bg-white text-red-600 font-bold text-xs px-4 py-1 rounded-full shadow-md">
                🔔 PENGUMUMAN TERBARU
            </div>
        </div>

        <!-- Kontainer isi pengumuman -->
        <div class="bg-white/95 rounded-2xl p-6 shadow-lg">
            <!-- Judul -->
            <h2 class="text-xl md:text-2xl font-extrabold text-gray-900 mb-3">
                {{ $announcement->title }}
            </h2>

            <!-- Isi pengumuman -->
            <p class="text-sm md:text-base leading-relaxed text-gray-700 mb-4">
                {{ $announcement->content }}
            </p>

            <!-- Tanggal -->
            <p class="text-xs text-gray-500 italic">
                Diumumkan pada {{ $announcement->created_at->format('d M Y, H:i') }}
            </p>
        </div>
    </div>
</section>
@else
<section id="announcement-section" class="flex justify-center items-center mt-10">
    <div class="bg-gray-100 border border-gray-300 rounded-xl shadow-md p-6 text-center w-full max-w-lg">
        <p class="text-gray-500">Belum ada pengumuman untuk Anda.</p>
    </div>
</section>
@endif


            {{-- DETAIL TPS --}}
            <section>
                <h2 class="text-2xl font-bold text-text-light dark:text-text-dark mb-4">Detail TPS {{ $tps->tps_code }}
                </h2>
                <div class="overflow-hidden rounded-xl border border-border-light dark:border-border-dark">
                    @if (session('success'))
                        <div
                            class="mb-4 rounded-md bg-green-50 dark:bg-green-900/30 p-3 text-sm text-green-700 dark:text-green-300 border border-green-200 dark:border-green-800">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="w-full text-sm border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                <td class="w-1/3 px-6 py-4 font-medium text-gray-600 dark:text-gray-400">Alamat</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                    {{ $tps->address }}
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                <td class="px-6 py-4 font-medium text-gray-600 dark:text-gray-400">Jumlah Pemilih</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                    <form action="{{ route('tps.update_voters', $tps->id) }}" method="POST"
                                        class="flex items-center gap-3">
                                        @csrf
                                        @method('PUT')
                                        <div class="relative">
                                            <input type="number" name="number_of_voters"
                                                value="{{ $tps->number_of_voters }}"
                                                class="w-28 rounded-lg border border-gray-300 dark:border-gray-700 bg-white/5 text-gray-900 dark:text-gray-100 px-3 py-1.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" />
                                        </div>
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 px-4 py-1.5 text-sm font-medium text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-500 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Simpan</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                <td class="px-6 py-4 font-medium text-gray-600 dark:text-gray-400">Ketua KPPS</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                    {{ $tps->ketua_kpps->name }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- DOKUMEN C HASIL --}}
            <section>
                <h3 class="text-xl font-bold text-text-light dark:text-text-dark mb-4">Dokumen C Hasil</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    @php
                        $docs = [
                            'PPWP' => 'ppwp.pdf',
                            'DPR RI' => 'dpr_ri.pdf',
                            'DPD' => 'dpd.pdf',
                            'DPRD Prov' => 'dprd_prov.pdf',
                            'DPRD Kab' => 'dprd_kab.pdf',
                        ];
                        $kecamatan = $tps->desa->kecamatan->name ?? 'kecamatan';
                        $desa = $tps->desa->name ?? 'desa';
                        $tps_folder = 'tps ' . $tps->tps_code;
                    @endphp

                    @foreach ($docs as $title => $filename)
                        @php
                            $path = "documents/$kecamatan/$desa/$tps_folder/$filename";
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
                                <span>Pratinjau Dokumen C Hasil</span>
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

            {{-- ANGGOTA KPPS --}}
            <section class="border-t border-border-light dark:border-border-dark pt-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-text-light dark:text-text-dark">Anggota KPPS</h3>
                        <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark">Daftar anggota KPPS
                            beserta jabatannya.</p>
                    </div>
                    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                        class="flex items-center gap-2 bg-primary hover:bg-primary/90 text-white font-medium py-2 px-4 rounded-lg text-sm transition">
                        <span class="material-icons text-base">add</span> Tambah Anggota
                    </button>
                </div>

                {{-- Modal Tambah Anggota --}}
                <div id="crud-modal" tabindex="-1" aria-hidden="true"
                    class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black/40 backdrop-blur-sm">
                    <div class="bg-white dark:bg-gray-700 rounded-xl shadow-lg w-full max-w-md p-5">
                        <div class="flex justify-between items-center border-b pb-3">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Anggota KPPS</h3>
                            <button data-modal-toggle="crud-modal"
                                class="text-gray-500 hover:text-red-500 transition">✕</button>
                        </div>
                        <form action="{{ route('kpps.anggota.store', $tps->id) }}" method="POST"
                            class="mt-4 space-y-4">
                            @csrf
                            <div>
                                <label for="name" class="block text-sm font-medium mb-1">Nama</label>
                                <input type="text" name="name" id="name" required
                                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 p-2 focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label for="job_title" class="block text-sm font-medium mb-1">Jabatan</label>
                                <select name="job_title" id="job_title"
                                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 p-2 focus:ring-primary focus:border-primary">
                                    <option value="">-- Pilih Jabatan --</option>
                                    @for ($i = 2; $i <= 7; $i++)
                                        <option value="KPPS {{ $i }}">KPPS {{ $i }}</option>
                                    @endfor
                                    <option value="Keamanan">Keamanan</option>
                                </select>
                            </div>
                            <button type="submit"
                                class="w-full bg-primary hover:bg-primary/90 text-white font-semibold py-2.5 rounded-lg transition">
                                Tambah
                            </button>
                        </form>
                    </div>
                </div>

                {{-- TABEL ANGGOTA --}}
                <div class="overflow-x-auto mt-4">
                    <table class="min-w-full divide-y divide-border-light dark:divide-border-dark">
                        <thead class="bg-gray-100 dark:bg-gray-700/60">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase">Jabatan</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-light dark:divide-border-dark">
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
                                                data-job="{{ $p->job_title }}" data-modal-target="editKPPSModal"
                                                data-modal-toggle="editKPPSModal">
                                                Edit
                                            </button>


                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('kpps.anggota.destroy', $p->id) }}" data-confirm
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

                                        <!-- Modal Edit KPPS -->
                                        <div id="editKPPSModal" tabindex="-1" aria-hidden="true"
                                            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                                            <div
                                                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
                                                <h3
                                                    class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">
                                                    Edit Anggota KPPS</h3>

                                                <form id="editKPPSForm" method="POST">
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
                                                            <option value="">-- Pilih Jabatan --</option>
                                                            @for ($i = 1; $i <= 7; $i++)
                                                                <option value="KPPS {{ $i }}">KPPS
                                                                    {{ $i }}</option>
                                                            @endfor
                                                            <option value="Keamanan">Keamanan</option>
                                                        </select>
                                                    </div>

                                                    <div class="flex justify-end space-x-2">
                                                        <button type="button" data-modal-hide="editKPPSModal"
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
                                    <td colspan="4" class="text-center text-gray-500 py-4">Belum ada anggota KPPS
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>



    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- EDIT MODAL & ACTION FORM --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editButtons = document.querySelectorAll('.edit-btn');
            const form = document.getElementById('editKPPSForm');
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
                    form.action = `/kpps/${id}`;
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
