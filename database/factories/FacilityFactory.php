<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FacilityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'type' => $this->faker->randomElement([
                'sekolah',
                'rumah_sakit',
                'puskesmas',
                'tempat_ibadah',
                'pasar',
                'lainnya',
            ]),
            'latitude' => $this->faker->latitude(-6.7, -6.1),
            'longitude' => $this->faker->longitude(106.5, 107.1),
            'address' => $this->faker->address,
            'description' => $this->faker->sentence,
        ];
    }
}
