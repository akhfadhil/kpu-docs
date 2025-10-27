<div id="editModal-{{ $member->id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full inset-0 h-modal h-full bg-black/50">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b dark:border-gray-700 rounded-t">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Edit Anggota KPPS
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white"
                    data-modal-hide="editModal-{{ $member->id }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 
                            111.414 1.414L11.414 10l4.293 4.293a1 1 0 
                            01-1.414 1.414L10 11.414l-4.293 4.293a1 1 
                            0 01-1.414-1.414L8.586 10 4.293 
                            5.707a1 1 0 010-1.414z" clip-rule="evenodd">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <form method="POST" action="{{ route('kpps.anggota.update', $member->id) }}" class="p-4 space-y-4">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div>
                    <label for="name-{{ $member->id }}"
                        class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                    <input type="text" name="name" id="name-{{ $member->id }}"
                        value="{{ old('name', $member->name) }}"
                        class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100"
                        required>
                </div>

                <!-- Jabatan -->
                <div>
                    <label for="job_title-{{ $member->id }}"
                        class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Jabatan</label>
                    <select name="job_title" id="job_title-{{ $member->id }}"
                        class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100"
                        required>
                        <option value="">-- Pilih Jabatan --</option>
                        @for ($i = 2; $i <= 7; $i++)
                            <option value="KPPS {{ $i }}" {{ $member->job_title == "KPPS $i" ? 'selected' : '' }}>
                                KPPS {{ $i }}
                            </option>
                        @endfor
                        <option value="Keamanan" {{ $member->job_title == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                    </select>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end space-x-2 pt-3 border-t dark:border-gray-700">
                    <button type="button" data-modal-hide="editModal-{{ $member->id }}"
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
