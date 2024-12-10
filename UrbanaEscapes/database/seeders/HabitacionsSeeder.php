<?php

namespace Database\Seeders;

use App\Models\Reservas;
use Illuminate\Support\Facades\Log;
use App\Models\Usuari;
use App\Models\Hotel;
use App\Models\Habitacion;

class HabitacionsSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        $hotels = Hotel::all();
        
        foreach ($hotels as $hotel) {
            $habitacionsNumber = $this->command->ask('Quantes habitacions vols crear per al hotel ' . $hotel->nom . '?', 100);
            $num_habitacio = 1;

            for ($i = 0; $i < $habitacionsNumber; $i++) {
                Habitacion::factory()->create([
                    'hotel_id' => $hotel->id,
                    'numHabitacion' => $num_habitacio++
                ]);
            }

            $this->command->info("  + Afegides $habitacionsNumber habitacions al hotel: $hotel->nom");
            Log::info("Habitacions afegides", ['hotel_id' => $hotel->id, 'habitacions_number' => $habitacionsNumber]);
        }
    }
}
