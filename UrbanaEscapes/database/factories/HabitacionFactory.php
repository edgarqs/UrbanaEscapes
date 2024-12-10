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
        $tipus = $faker->randomElement(['estandar', 'deluxe', 'suite', 'adaptada']);

        switch ($tipus) {
            case 'estandar':
                $preu = $faker->randomFloat(2, 50, 100);
                break;
            case 'deluxe':
                $preu = $faker->randomFloat(2, 100, 150);
                break;
            case 'suite':
                $preu = $faker->randomFloat(2, 150, 200);
                break;
            case 'adaptada':
                $preu = $faker->randomFloat(2, 100, 200);
                break;
        }
        
        return [
            'tipus' => $tipus,
            'llits' => $faker->randomElement(['1', '2', '3', '4']),
            'llits_supletoris' => $faker->randomElement(['0', '1', '2']),
            'preu' => $preu,
            'hotel_id' => null,
        ];
    }
}
