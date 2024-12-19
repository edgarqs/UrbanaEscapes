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
        $dataEntrada = $faker->dateTimeBetween('-1 year', '+1 year');
        $dataSortida = (clone $dataEntrada)->modify("+$dias days");

        //? Calcular el preu total de la reserva amb serveis extra
        $preuHabitacio = $habitacion->preu * $dias;
        $preuServeis = $habitacion->serveis->sum('preu');
        $preuTotal = $preuHabitacio + $preuServeis;

        //? Verificar que no haya otra reserva en las mismas fechas
        while (Reservas::where('habitacion_id', $habitacion->id)
            ->where(function ($query) use ($dataEntrada, $dataSortida) {
                $query->whereBetween('data_entrada', [$dataEntrada, $dataSortida])
                    ->orWhereBetween('data_sortida', [$dataEntrada, $dataSortida]);
            })->exists()
        ) {
            $dataEntrada = $faker->dateTimeBetween('-1 year', '+1 year');
            $dataSortida = (clone $dataEntrada)->modify("+$dias days");
        }

        //? Estableix l'estat de la reserva según la fecha
        if ($dataEntrada > Carbon::now()) {
            $estatReserva = $faker->randomElement(['reservada', 'cancelada']);
        } elseif ($dataSortida < Carbon::now()) {
            $estatReserva = $faker->randomElement(['checkout', 'cancelada']);
        } else {
            $estatReserva = $faker->randomElement(['reservada', 'checkin', 'checkout', 'cancelada']);
        }

        //? Actualitza l'estat de l'habitació segons l'estat de la reserva (realista)
        switch ($estatReserva) {
            case 'checkin':
                $habitacion->estat = 'ocupada';
                break;
            case 'reservada':
            case 'checkout':
            case 'cancelada':
                $habitacion->estat = 'lliure';
                break;
        }
        $habitacion->save();

        return [
            'habitacion_id' => $habitacion->id,
            'usuari_id' => Usuari::inRandomOrder()->first()->id, //? Selecciona un usuario aleatorio
            'data_entrada' => $dataEntrada,
            'data_sortida' => $dataSortida,
            'preu_total' => $preuTotal,
            'estat' => $estatReserva,
        ];
    }
}
