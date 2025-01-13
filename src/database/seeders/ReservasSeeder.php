<?php

namespace Database\Seeders;

use App\Models\Reservas;
use App\Models\Usuari;
use App\Models\Habitacion;
use App\Models\Hotel;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Seeder;

class ReservasSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener todos los hoteles
        $hotels = Hotel::all();

        foreach ($hotels as $hotel) {
            $reservasNumber = $this->command->ask('Quantes reserves vols crear per al hotel ' . $hotel->nom . '?', 100);
            
            // Obtener habitaciones del hotel
            $habitacions = Habitacion::where('hotel_id', $hotel->id)->get();

            // Crear reservas
            for ($i = 0; $i < $reservasNumber; $i++) {
                $habitacio = $habitacions->random();
                $usuari = Usuari::factory()->create();

                Reservas::factory()->create([
                    'usuari_id' => $usuari->id,
                    'habitacion_id' => $habitacio->id,
                    'estat' => 'reservada',
                    'preu_total' => rand(100, 1000),
                ]);
            }

            $this->command->info("  + Afegides $reservasNumber reserves al hotel: $hotel->nom");
            Log::channel('info_log')->info("Reserves afegides", ['reservasNumber' => $reservasNumber, 'hotel_id' => $hotel->id]);
        }
    }
}