<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Desa;

class TpsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tps_code' => 'TPS ' . $this->faker->numberBetween(1, 1000),
            'address' => $this->faker->address,
            'number_of_voters' => $this->faker->numberBetween(50, 500),
            'desa_id' => Desa::factory(),
        ];
    }

    // database/factories/TpsFactory.php

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Tps $tps) {
            // Buat anggota KPPS terlebih dahulu
            $kpps = \App\Models\KPPSMember::create([
                'name' => 'Anggota KPPS TPS ' . $tps->id,
                'job_title' => 'Anggota',
                'tps_id' => $tps->id,
            ]);

            // Buat user yang morph ke KPPSMember
            $kpps->user()->create([
                'name' => $kpps->name,
                'username' => 'kpps' . $tps->id,
                'email' => 'kpps' . $kpps->id . '@example.com',
                'password' => bcrypt('password'),
                'role_id' => 4,
            ]);
        });
    }


}
