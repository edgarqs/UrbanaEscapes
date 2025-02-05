<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Hotel;

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
        $tipus = $faker->randomElement(['Estandar', 'Deluxe', 'Suite', 'Adaptada']);

        switch ($tipus) {
            case 'Estandar':
                $preu = $faker->randomFloat(2, 40, 80);
                break;
            case 'Deluxe':
                $preu = $faker->randomFloat(2, 80, 130);
                break;
            case 'Suite':
                $preu = $faker->randomFloat(2, 130, 200);
                break;
            case 'Adaptada':
                $preu = $faker->randomFloat(2, 80, 130);
                break;
        }
        
        return [
            'tipus' => $tipus,
            'llits' => $faker->randomElement(['1', '2', '3', '4']),
            'llits_supletoris' => $faker->randomElement(['0', '1', '2']),
            'preu' => $preu,
            'hotel_id' => null,
            // 'estat' => $faker->randomElement(['Lliure', 'Ocupada', 'Bloquejada']),
        ];
    }
}
