<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservas>
 */
class ReservasFactory extends Factory
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
            'habitacion_id' => random_int(1, 100),
            'usuari_id' => random_int(1, 50),
            'data_entrada' => $faker->dateTimeThisYear(),
            'data_sortida' => $faker->dateTimeThisYear(),
            'preu_total' => $faker->randomFloat(2, 0, 1000),
            'estat' => $faker->randomElement(['lliure', 'ocupada', 'pendent']),
        ];
    }
}
