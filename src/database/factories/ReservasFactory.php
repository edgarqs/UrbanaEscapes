<?php

namespace Database\Factories;

use App\Models\Habitacion;
use App\Models\Usuari;
use App\Models\Reservas;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;


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
        $habitacion = Habitacion::inRandomOrder()->first();
        $dias = $faker->numberBetween(1, 15);
        $data_entrada = $faker->dateTimeBetween('-1 year', '+1 year');
        $data_sortida = (clone $data_entrada)->modify("+$dias days");
        $preu_total = $habitacion->preu * $dias;

        //? Verificar que no haya otra reserva en las mismas fechas
        while (Reservas::where('habitacion_id', $habitacion->id)
            ->where(function ($query) use ($data_entrada, $data_sortida) {
                $query->whereBetween('data_entrada', [$data_entrada, $data_sortida])
                    ->orWhereBetween('data_sortida', [$data_entrada, $data_sortida]);
            })->exists()
        ) {
            $data_entrada = $faker->dateTimeBetween('-1 year', '+1 year');
            $data_sortida = (clone $data_entrada)->modify("+$dias days");
        }

        //? Estableix l'estat de la reserva según la fecha
        if ($data_entrada > Carbon::now()) {
            $estat = $faker->randomElement(['reservada', 'cancelada']);
        } elseif ($data_sortida < Carbon::now()) {
            $estat = $faker->randomElement(['checkout', 'cancelada']);
        } else {
            $estat = $faker->randomElement(['reservada', 'checkin', 'checkout', 'cancelada']);
        }

        //? Actualitza l'estat de l'habitació segons l'estat de la reserva (realista)
        switch ($estat) {
            case 'reservada':
                $habitacion->estat = 'pendent';
                break;
            case 'checkin':
                $habitacion->estat = 'ocupada';
                break;
            case 'checkout':
            case 'cancelada':
                $habitacion->estat = 'lliure';
                break;
        }
        $habitacion->save();

        return [
            'habitacion_id' => $habitacion->id,
            'usuari_id' => Usuari::inRandomOrder()->first()->id, //? Selecciona un usuario aleatorio
            'data_entrada' => $data_entrada,
            'data_sortida' => $data_sortida,
            'preu_total' => $preu_total,
            'estat' => $estat,
        ];
    }
}
