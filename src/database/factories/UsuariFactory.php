<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuari>
 */
class UsuariFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Configurar Faker en español
        $faker = \Faker\Factory::create('es_ES');

        return [
            'nom' => $faker->name(),
            'email' => $faker->unique()->safeEmail(),
            'dni' => $faker->unique()->dni(),
            'rol_id' => 3,
        ];
    }
}
