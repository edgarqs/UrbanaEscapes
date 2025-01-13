<?php

namespace Database\Factories;

use App\Models\Habitacion;
use App\Models\Usuari;
use App\Models\Reservas;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ReservasFactory extends Factory
{
    protected $model = Reservas::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('es_ES');
        $habitacion = Habitacion::inRandomOrder()->first();
        $dias = $faker->numberBetween(1, 15);
        $dataEntrada = $faker->dateTimeBetween('-4 months', '+4 months');
        $dataSortida = (clone $dataEntrada)->modify("+$dias days");

        // Calcular el preu total de la reserva amb serveis extra
        $preuHabitacio = $habitacion->preu * $dias;
        $preuServeis = $habitacion->serveis->sum('preu');
        $preuTotal = $preuHabitacio + $preuServeis;

        // Verificar que no haya otra reserva en las mismas fechas a menos que el estado sea "Cancelada"
        while (Reservas::where('habitacion_id', $habitacion->id)
            ->where(function ($query) use ($dataEntrada, $dataSortida) {
                $query->where(function ($query) use ($dataEntrada, $dataSortida) {
                    $query->whereBetween('data_entrada', [$dataEntrada, $dataSortida])
                        ->orWhereBetween('data_sortida', [$dataEntrada, $dataSortida])
                        ->orWhere(function ($query) use ($dataEntrada, $dataSortida) {
                            $query->where('data_entrada', '<', $dataEntrada)
                                  ->where('data_sortida', '>', $dataSortida);
                        });
                })
                    ->where('estat', '!=', 'Cancelada');
            })->exists()
        ) {
            $dataEntrada = $faker->dateTimeBetween('-4 months', '+4 months');
            $dataSortida = (clone $dataEntrada)->modify("+$dias days");
        }

        // Estableix l'estat de la reserva según la fecha
        if ($dataSortida < Carbon::now()) {
            $estatReserva = $faker->randomElement(['Checkout', 'Cancelada']);
        } elseif ($dataEntrada <= Carbon::now() && $dataSortida >= Carbon::now()) {
            $estatReserva = 'Checkin';
        } else {
            $estatReserva = $faker->randomElement(['Reservada', 'Cancelada']);
        }

        // Actualitza l'estat de l'habitació segons l'estat de la reserva
        if ($estatReserva == 'Checkin') {
            $habitacion->estat = 'Ocupada';
        } elseif ($estatReserva == 'Checkout' || $estatReserva == 'Cancelada') {
            $habitacion->estat = 'Lliure';
        }

        $habitacion->save();

        return [
            'habitacion_id' => $habitacion->id,
            'usuari_id' => Usuari::inRandomOrder()->first()->id,
            'data_entrada' => $dataEntrada,
            'data_sortida' => $dataSortida,
            'preu_total' => $preuTotal,
            'estat' => $estatReserva,
        ];
    }
}
