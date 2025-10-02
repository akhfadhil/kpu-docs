<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Desa;

class PPSMemberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'job_title' => $this->faker->randomElement(['Ketua', 'Anggota']),
            'desa_id' => Desa::factory(),
        ];
    }
}
