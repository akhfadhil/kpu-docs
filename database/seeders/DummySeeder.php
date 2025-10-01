<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\TPS;
use App\Models\KPPSMember;
use App\Models\PPKMember;
use App\Models\PPSMember;

class DummySeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $adminRole = Role::create(['role' => 'admin']);
        $ppkRole   = Role::create(['role' => 'ppk']);
        $ppsRole   = Role::create(['role' => 'pps']);
        $kppsRole  = Role::create(['role' => 'kpps']);

        // Kecamatan
        $kecamatan = Kecamatan::create([
            'name' => 'Kecamatan Dummy',
        ]);

        // Desa
        $desa = Desa::create([
            'name' => 'Desa Dummy',
            'kecamatan_id' => $kecamatan->id,
        ]);

        // TPS
        $tps = TPS::create([
            'tps_code' => 'TPS 001',
            'address' => 'Jl. Dummy No.1',
            'number_of_voters' => 123,
            'desa_id' => $desa->id,
        ]);

        // Anggota
        $anggotaPpk = PPKMember::create([
            'name' => 'Anggota PPK 1',
            'job_title' => 'Ketua PPK',
            'kecamatan_id' => $kecamatan->id,
        ]);

        $anggotaPps = PPSMember::create([
            'name' => 'Anggota PPS 1',
            'job_title' => 'Ketua PPS',
            'desa_id' => $desa->id,
        ]);

        $anggotaKpps = KPPSMember::create([
            'name' => 'Anggota KPPS 1',
            'job_title' => 'Ketua KPPS',
            'tps_id' => $tps->id,
        ]);

        // Users
        $adminUser = User::create([
            'name' => 'Admin Dummy',
            'email' => 'admin@dummy.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id,
        ]);

        $ppkUser = User::create([
            'name' => 'User PPK',
            'email' => 'ppk@dummy.com',
            'password' => bcrypt('password'),
            'role_id' => $ppkRole->id,
            'userable_id' => $anggotaPpk->id,
            'userable_type' => PPKMember::class,
        ]);

        $ppsUser = User::create([
            'name' => 'User PPS',
            'email' => 'pps@dummy.com',
            'password' => bcrypt('password'),
            'role_id' => $ppsRole->id,
            'userable_id' => $anggotaPps->id,
            'userable_type' => PPSMember::class,
        ]);

        $kppsUser = User::create([
            'name' => 'User KPPS',
            'email' => 'kpps@dummy.com',
            'password' => bcrypt('password'),
            'role_id' => $kppsRole->id,
            'userable_id' => $anggotaKpps->id,
            'userable_type' => KPPSMember::class,
        ]);

        // Dokumen (contoh upload oleh desa lewat user PPS)
        $desa->document()->create([
            'doc_type' => 'd_hasil_desa',
            'path' => 'document/d_hasil_desa.pdf',
            'uploaded_by' => $ppsUser->id,
        ]);
    }
}
