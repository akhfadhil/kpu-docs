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
}
