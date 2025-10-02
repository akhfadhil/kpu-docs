<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KecamatanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Kecamatan ' . $this->faker->city,
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Kecamatan $kecamatan) {
            // Buat PPKMember
            $ppk = \App\Models\PPKMember::create([
                'name' => 'PPK ' . $kecamatan->name,
                'job_title' => 'Ketua PPK',
                'kecamatan_id' => $kecamatan->id,
            ]);

            // Buat User yang morph ke PPKMember
            $ppk->user()->create([
                'name' => $ppk->name,
                'email' => 'ppk' . $ppk->id . '@example.com',
                'password' => bcrypt('password'),
                'role_id' => 2, // Role PPK
            ]);
        });
    }
}
