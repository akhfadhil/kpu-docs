<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    public function definition(): array
    {
        $roles = ['admin', 'ppk', 'pps', 'kpps'];
        return [
            'role' => $this->faker->unique()->randomElement($roles),
        ];
    }
}
