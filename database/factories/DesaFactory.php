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
    // database/factories/DesaFactory.php

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Desa $desa) {
            $pps = \App\Models\PPSMember::create([
                'name' => 'PPS Desa ' . $desa->id,
                'job_title' => 'Ketua PPS',
                'desa_id' => $desa->id,
            ]);

            $pps->user()->create([
                'name' => $pps->name,
                'username' => 'pps' . $desa->id,
                'email' => 'pps' . $desa->id . '@example.com',
                'password' => bcrypt('password'),
                'role_id' => 3, // role 'pps'
                // 'userable_id' => $pps->id,
                // 'userable_type' => \App\Models\PPSMember::class,
            ]);
        });
    }

}
