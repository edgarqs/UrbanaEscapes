<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Habitacion>
 */
class HabitacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('es_ES');
        return [
            'tipus' => $faker->randomElement(['estandar', 'deluxe', 'suite', 'adaptada']),
            'llits' => $faker->randomElement(['1', '2', '3', '4']),
            'llits_supletoris' => $faker->randomElement(['0', '1', '2']),
            'preu' => $faker->randomFloat(2, 0, 1000),
            'hotel_id' => random_int(1, 1),
        ];
    }
}
