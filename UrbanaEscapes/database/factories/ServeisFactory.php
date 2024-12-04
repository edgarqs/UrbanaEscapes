<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Serveis>
 */
class ServeisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'nom' => ['Microones', 'TV', 'Mascotas', 'Minibar', 'Cafetera'],
            'preu' => [5, 30, 50, 15, 10],
        ];
    }
}
