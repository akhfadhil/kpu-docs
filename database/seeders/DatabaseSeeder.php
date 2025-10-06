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
        // buat role (pakai firstOrCreate biar tidak double)
        $roles = ['admin', 'ppk', 'pps', 'kpps'];
        foreach ($roles as $role) {
            \App\Models\Role::firstOrCreate(['role' => $role]);
        }

        // buat kecamatan dengan desa & tps (lebih sedikit)
        \App\Models\Kecamatan::factory()
            ->count(2)
            ->has(
                \App\Models\Desa::factory()
                    ->count(2)
                    ->has(
                        \App\Models\Tps::factory()->count(1)
                    )
            )
            ->create();

        // buat user admin (pakai firstOrCreate biar kalau sudah ada, dipakai lagi)
        $adminRole = \App\Models\Role::where('role','admin')->first();
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
