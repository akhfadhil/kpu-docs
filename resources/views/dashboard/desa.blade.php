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

        <!-- Daftar TPS -->
        <div class="bg-white shadow-lg rounded-2xl p-6">
            <h2 class="text-xl font-semibold mb-4">Daftar TPS di Desa {{ $desa->name }}</h2>
            <ul class="space-y-4">
                <!-- TPS 1 -->
                @foreach ($desa->tps as $tps)
                    <li class="flex items-center justify-between border-b pb-3">
                        <div>
                            <p class="font-semibold">{{ $tps->tps_code }}</p>
                            <p class="text-sm text-gray-600">{{ $tps->address }}</p>
                        </div>
                        <a href="/tps/{{ $tps->id }}"
                            class="bg-blue-600 hover:bg-blue-700 active:scale-95 transform transition duration-200 text-white font-semibold px-4 py-2 rounded-xl shadow">
                            Lihat Dokumen
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

</x-layout>
