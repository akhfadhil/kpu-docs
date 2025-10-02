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
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $this->call(DummySeeder::class);
        
        // buat role (pakai firstOrCreate biar tidak double)
        $roles = ['admin', 'ppk', 'pps', 'kpps'];
        foreach ($roles as $role) {
            \App\Models\Role::firstOrCreate(['role' => $role]);
        }

        // buat kecamatan dengan desa & tps (lebih sedikit)
        \App\Models\Kecamatan::factory()
            ->count(2) // hanya 2 kecamatan
            ->has(\App\Models\Desa::factory()
                ->count(2) // tiap kecamatan punya 2 desa
                ->has(\App\Models\Tps::factory()->count(1)) // tiap desa 1 TPS
            )
            ->create();

        // buat anggota PPK, PPS, KPPS lebih sedikit
        \App\Models\PPKMember::factory()->count(2)->create();
        \App\Models\PPSMember::factory()->count(3)->create();
        \App\Models\KPPSMember::factory()->count(5)->create();

        // buat user admin (pakai firstOrCreate biar kalau sudah ada, dipakai lagi)
        $adminRole = \App\Models\Role::where('role','admin')->first();
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'role_id' => $adminRole->id,
            ]
        );

        // contoh buat dokumen random (lebih sedikit)
        \App\Models\Document::factory()->count(3)->create();

    }

}
