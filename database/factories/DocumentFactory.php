<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'doc_type' => $this->faker->randomElement(['d_hasil_kec', 'd_hasil_desa', 'c_hasil_ppwp', 'c_hasil_dpr_ri', 'c_hasil_dpd', 'c_hasil_dprd_prov', 'c_hasil_dprdp_kab']),
            'path' => 'document/' . $this->faker->uuid . '.pdf',
            'uploaded_by' => User::factory(),
            'documentable_id' => null,
            'documentable_type' => null,
        ];
    }
}
