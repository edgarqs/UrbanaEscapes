<?php

namespace Database\Factories;

use App\Models\Feedbacks;
use App\Models\Reservas;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class FeedbacksFactory extends Factory
{
    protected $model = Feedbacks::class;

    public function definition()
    {
        $faker = Faker::create('es_ES');

        return [
            'reserva_id' => Reservas::where('estat', 'Checkout')->inRandomOrder()->first()->id,
            'estrelles' => $faker->numberBetween(1, 5),
            'comentari' => $faker->realText(200),
        ];
    }
}
