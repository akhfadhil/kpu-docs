<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kecamatan;

class DesaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Desa ' . $this->faker->streetName,
            'kecamatan_id' => Kecamatan::factory(),
        ];
    }
}
