<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kecamatan;

class PPKMemberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'job_title' => $this->faker->randomElement(['Ketua', 'Anggota']),
            'kecamatan_id' => Kecamatan::factory(),
        ];
    }
}
