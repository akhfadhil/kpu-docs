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
}
