<?php

namespace Database\Factories;

use App\Models\Reservas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedback>
 */
class FeedbackFactory extends Factory
{
    public function definition()
    {
        return [
            'reserva_id' => Reservas::factory(),
            'estrelles' => $this->faker->numberBetween(1, 5),
            'comentari' => $this->faker->paragraph,
        ];
    }
}
