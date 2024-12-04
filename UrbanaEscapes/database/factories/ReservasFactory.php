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
        $dias = $faker->numberBetween(1, 15);
        $data_entrada = $faker->dateTimeThisYear();
        $data_sortida = (clone $data_entrada)->modify("+$dias days");

        return [
            'habitacion_id' => random_int(1, 100),
            'usuari_id' => random_int(1, 50),
            'data_entrada' => $data_entrada,
            'data_sortida' => $data_sortida,
            'preu_total' => $faker->randomFloat(2, 50, 500),
            'estat' => $faker->randomElement(['confirmada','pendent']),
        ];
    }
}
