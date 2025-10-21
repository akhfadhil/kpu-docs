<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    // public function run(): void
    // {        
    //     // buat role (pakai firstOrCreate biar tidak double)
    //     $roles = ['admin', 'ppk', 'pps', 'kpps'];
    //     foreach ($roles as $role) {
    //         \App\Models\Role::firstOrCreate(['role' => $role]);
    //     }

    //     // buat kecamatan dengan desa & tps (lebih sedikit)
    //     \App\Models\Kecamatan::factory()
    //         ->count(2)
    //         ->has(
    //             \App\Models\Desa::factory()
    //                 ->count(2)
    //                 ->has(
    //                     \App\Models\TPS::factory()->count(1)
    //                 )
    //         )
    //         ->create();

    //     // buat user admin (pakai firstOrCreate biar kalau sudah ada, dipakai lagi)
    //     $adminRole = \App\Models\Role::where('role','admin')->first();
    //     \App\Models\User::firstOrCreate(
    //         ['email' => 'admin@demo.com'],
    //         [
    //             'name' => 'Super Admin',
    //             'username' => 'superadmin',
    //             'password' => bcrypt('password'),
    //             'role_id' => $adminRole->id,
    //         ]
    //     );
    // }

    public function run(): void
    {
        // 1️⃣ Buat role (tidak duplikat)
        $roles = ['admin', 'ppk', 'pps', 'kpps'];
        foreach ($roles as $role) {
            \App\Models\Role::firstOrCreate(['role' => $role]);
        }

        // 2️⃣ Daftar kecamatan dan desa buatanmu sendiri
        $wilayah = [
            'Bangorejo' => [
                'Bangorejo',
                'Kebondalem',
                'Ringintelu',
                'Sambimulyo',
                'Sambirejo',
                'Sukorejo',
                'Temurejo',
            ],
            'Banyuwangi' => [
                'Kampung Mandar',
                'Kampung Melayu',
                'Karangrejo',
                'Kebalenan',
                'Kepatihan',
                'Kertosari',
                'Lateng',
                'Pakis',
                'Panderejo',
                'Penganjuran',
                'Pengantigan',
                'Singonegaran',
                'Singotrunan',
                'Sobo',
                'Sumber Rejo',
                'Taman Baru',
                'Temenggungan',
                'Tukang Kayu',
            ],
            'Blimbingsari' => [
                'Badean',
                'Blimbingsari',
                'Bomo',
                'Gintangan',
                'Kaligung',
                'Kaotan',
                'Karangrejo',
                'Patoman',
                'Sukojati',
                'Watukebo',
            ],
            'Cluring' => [
                'Benculuk',
                'Cluring',
                'Kaliploso',
                'Plampangrejo',
                'Sarimulyo',
                'Sembulung',
                'Sraten',
                'Tamanagung',
                'Tampo',
            ],
            'Gambiran' => [
                'Gambiran',
                'Jajag',
                'Purwodadi',
                'Wringinagung',
                'Wringinrejo',
                'Yosomulyo',
            ],
            'Genteng' => [
                'Genteng Kulon',
                'Genteng Wetan',
                'Kaligondo',
                'Kembiritan',
                'Setail',
            ],
            'Giri' => [
                'Boyolangu',
                'Giri',
                'Grogol',
                'Jambesari',
                'Mojopanggung',
                'Penataban',
            ],
            'Glagah' => [
                'Bakungan',
                'Banjarsari',
                'Glagah',
                'Kampunganyar',
                'Kemiren',
                'Kenjo',
                'Olehsari',
                'Paspan',
                'Rejosari',
                'Tamansuruh',
            ],
            'Glenmore' => [
                'Bumiharjo',
                'Karangharjo',
                'Margomulyo',
                'Sepanjang',
                'Sumbergondo',
                'Tegalharjo',
                'Tulungrejo',
            ],
            'Kabat' => [
                'Bareng',
                'Benelan Lor',
                'Bunder',
                'Dadapan',
                'Gombolirang',
                'Kabat',
                'Kalirejo',
                'Kedayunan',
                'Labanasem',
                'Macan Putih',
                'Pakistaji',
                'Pendarungan',
                'Pondoknongko',
                'Tambong',
            ],
            'Kalibaru' => [
                'Banyuanyar',
                'Kajarharjo',
                'Kalibarukulon',
                'Kalibarumanis',
                'Kalibaruwetan',
                'Kebonrejo',
            ],
            'Kalipuro' => [
                'Bulusan',
                'Bulusari',
                'Gombengsari',
                'Kalipuro',
                'Kelir',
                'Ketapang',
                'Klatak',
                'Pesucen',
                'Telemung',
            ],
            'Licin' => [
                'Banjar',
                'Gumuk',
                'Jelun',
                'Kluncing',
                'Licin',
                'Pakel',
                'Segobang',
                'Tamansari',
            ],
            'Muncar' => [
                'Blambangan',
                'Kedungrejo',
                'Kedungringin',
                'Kumendung',
                'Sumber Beras',
                'Sumbersewu',
                'Tambakrejo',
                'Tapanrejo',
                'Tembokrejo',
                'Wringinputih',
            ],
            'Pesanggaran' => [
                'Kandangan',
                'Pesanggaran',
                'Sarongan',
                'Sumberagung',
                'Sumbermulyo',
            ],
            'Purwoharjo' => [
                'Bulurejo',
                'Glagahagung',
                'Grajagan',
                'Karetan',
                'Kradenan',
                'Purwoharjo',
                'Sidorejo',
                'Sumberasri',
            ],
            'Rogojampi' => [
                'Aliyan',
                'Bubuk',
                'Gitik',
                'Gladag',
                'Karangbendo',
                'Kedaleman',
                'Lemahbangdewo',
                'Mangir',
                'Pengatigan',
                'Rogojampi',
            ],
            'Sempu' => [
                'Gendoh',
                'Jambewangi',
                'Karangsari',
                'Sempu',
                'Tegalarum',
                'Temuasri',
                'Temuguruh',
            ],
            'Siliragung' => [
                'Barurejo',
                'Buluagung',
                'Kesilir',
                'Seneporejo',
                'Siliragung',
            ],
            'Singojuruh' => [
                'Alasmalang',
                'Benelan Kidul',
                'Cantuk',
                'Gambor',
                'Gumirih',
                'Kemiri',
                'Lemahbangkulon',
                'Padang',
                'Singojuruh',
                'Singolatren',
                'Sumberbaru',
            ],
            'Songgon' => [
                'Balak',
                'Bangunsari',
                'Bayu',
                'Bedewang',
                'Parangharjo',
                'Songgon',
                'Sragi',
                'Sumberarum',
                'Sumberbulu',
            ],
            'Srono' => [
                'Bagorejo',
                'Kebaman',
                'Kepundungan',
                'Parijatah Kulon',
                'Parijatah Wetan',
                'Rejoagung',
                'Sukomaju',
                'Sukonatar',
                'Sumbersari',
                'Wonosobo',
            ],
            'Tegaldlimo' => [
                'Kalipait',
                'Kedungasri',
                'Kedunggebang',
                'Kedungwungu',
                'Kendalrejo',
                'Purwoagung',
                'Purwoasri',
                'Tegaldlimo',
                'Wringinpitu',
            ],
            'Tegalsari' => [
                'Dasri',
                'Karangdoro',
                'Karangmulyo',
                'Tamansari',
                'Tegalrejo',
                'Tegalsari',
            ],
            'Wongsorejo' => [
                'Alasbuluh',
                'Alasrejo',
                'Bajulmati',
                'Bangsring',
                'Bengkak',
                'Bimorejo',
                'Sidodadi',
                'Sidowangi',
                'Sumberanyar',
                'Sumberkencono',
                'Watukebo',
                'Wongsorejo',
            ],
        ];

        // 3️⃣ Loop daftar manual, buat kecamatan–desa–tps
        foreach ($wilayah as $kecamatanNama => $daftarDesa) {
            $kecamatan = \App\Models\Kecamatan::firstOrCreate([
                'name' => $kecamatanNama,
            ]);

            foreach ($daftarDesa as $desaNama) {
                $desa = \App\Models\Desa::firstOrCreate([
                    'name' => $desaNama,
                    'kecamatan_id' => $kecamatan->id,
                ]);

                // Tambahkan 10 TPS untuk setiap desa
                for ($i = 1; $i <= 10; $i++) {
                    \App\Models\TPS::firstOrCreate([
                        'desa_id' => $desa->id,
                        'tps_code' => "TPS-{$i}-{$desaNama}",
                    ], [
                        'address' => "Alamat TPS {$i} {$desaNama}",
                        'number_of_voters' => rand(100, 500),
                    ]);
                }
  
            }
        }

        // 4️⃣ Buat user admin
        $adminRole = \App\Models\Role::where('role', 'admin')->first();
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => bcrypt('password'),
                'role_id' => $adminRole->id,
            ]
        );
    }


}
