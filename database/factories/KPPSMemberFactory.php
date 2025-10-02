<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tps;

class KPPSMemberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'job_title' => $this->faker->randomElement(['Ketua', 'Anggota']),
            'tps_id' => Tps::factory(),
        ];
    }
}
