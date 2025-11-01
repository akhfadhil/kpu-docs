<x-layout>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Upload Documents D Hasil Kecamatan</h1>
    <p class="text-gray-500 dark:text-gray-400 mb-8">
        Please upload the 5 required documents to proceed.
    </p>

    <!-- Grid Dokumen -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @php
            $docs = [
                ['name' => 'PPWP', 'desc' => 'Presidential Election'],
                ['name' => 'DPR_RI', 'desc' => 'National Parliament'],
                ['name' => 'DPD', 'desc' => 'Regional Council'],
                ['name' => 'DPRD_Prov', 'desc' => 'Provincial Parliament'],
                ['name' => 'DPRD_Kab', 'desc' => 'Regency Parliament'],
            ];
            @endphp

            @foreach ($docs as $doc)
            @php

            $existing = $kecamatan->document->firstWhere('doc_type', $doc['name']) ?? null;
            @endphp
            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-4 flex flex-col items-center text-center hover:border-primary/50 transition">
                <span class="material-icons text-4xl text-primary mb-2">description</span>
                <h4 class="font-semibold text-gray-900 dark:text-white">{{ $doc['name'] }}</h4>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">{{ $doc['desc'] }}</p>

                <button
                data-modal-target="modal-{{ Str::slug($doc['name']) }}"
                data-modal-toggle="modal-{{ Str::slug($doc['name']) }}"
                class="w-full bg-primary text-white hover:bg-primary/90 font-medium py-2 px-4 rounded-lg text-sm transition duration-150 ease-in-out">
                Upload
                </button>

                @if ($existing)
                <p class="mt-2 text-xs text-green-600 dark:text-green-400">
                    Sudah diupload
                </p>
                @endif
            </div>

            <!-- Modal Upload -->
            <div id="modal-{{ Str::slug($doc['name']) }}" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full inset-0 h-[100vh] bg-black/40 backdrop-blur-sm">
                <div class="relative w-full max-w-lg p-4">
                <!-- Modal content -->
                <div class="relative bg-white rounded-xl shadow dark:bg-gray-800">
                    <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Upload Dokumen {{ $doc['name'] }}
                        </h3>
                        <button type="button"
                            class="text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-lg text-sm w-8 h-8 flex justify-center items-center"
                            data-modal-hide="modal-{{ Str::slug($doc['name']) }}">
                            <span class="material-icons text-base">close</span>
                        </button>
                    </div>

                    <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                        @csrf
                        <input type="hidden" name="doc_type" value="{{ $doc['name'] }}">

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Pilih File PDF
                            </label>
                            <input type="file" name="file" accept="application/pdf"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary">
                        </div>

                        @if ($existing)
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                            File sebelumnya: <span class="text-blue-600 dark:text-blue-400">{{ basename($existing->path) }}</span>
                            </p>
                        @endif

                        <div class="flex justify-end">
                            <button type="submit"
                            class="inline-flex items-center px-5 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary/90 focus:ring-4 focus:ring-primary/30">
                            <span class="material-icons text-sm mr-1">upload_file</span>
                            Upload
                            </button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            @endforeach
        </div>

        <p class="text-center text-sm text-gray-400 dark:text-gray-500 mt-8">
            Supported file types: <span class="font-medium">PDF</span>
        </p>
    </div>
    </div>
</x-layout>
