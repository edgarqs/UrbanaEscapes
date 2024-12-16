<?php

namespace Database\Factories;

use App\Models\Habitacion;
use App\Models\Serveis;
use App\Models\Usuari;

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
        $habitacion_id = Habitacion::inRandomOrder()->first()->id;
        $faker = \Faker\Factory::create('es_ES');
        $dias = $faker->numberBetween(1, 15);
        $data_entrada = $faker->dateTimeThisYear();
        $data_sortida = (clone $data_entrada)->modify("+$dias days");
        $preu_total = Habitacion::getHabitacionPreu($habitacion_id)* $dias;
        
        return [
            'habitacion_id' => $habitacion_id, //? Selecciona un ID de habitación existente de forma aleatoria
            'usuari_id' => Usuari::inRandomOrder()->first()->id, //? Seleciona un usuario existente
            'data_entrada' => $data_entrada,
            'data_sortida' => $data_sortida,
            'preu_total' => $preu_total,
            'estat' => $faker->randomElement(['reservada', 'checkin', 'checkout', 'cancelada']),
        ];
    }
}
