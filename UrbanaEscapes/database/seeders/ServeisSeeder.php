<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Log;
use App\Models\Serveis;
use App\Models\Habitacion;
use App\Models\Hotel;

class ServeisSeeder extends DatabaseSeeder
{

    public function run(): void
    {
        $hotels = Hotel::all();
        
        // Creación de servicios
        $serveis = [
            ['nom' => 'Microones', 'preu' => 5],
            ['nom' => 'TV', 'preu' => 30],
            ['nom' => 'Mascotas', 'preu' => 50],
            ['nom' => 'Minibar', 'preu' => 15],
            ['nom' => 'Cafetera', 'preu' => 10],
        ];
        foreach ($serveis as $servei) {
            Serveis::create($servei);
        }

        // Asignación de servicios a habitaciones
        foreach ($hotels as $hotel) {
            $habitacions = Habitacion::where('hotel_id', $hotel->id)->get();
            foreach ($habitacions as $habitacio) {
                $randomServeis = Serveis::inRandomOrder()->take(rand(1, 3))->pluck('id');
                $habitacio->serveis()->attach($randomServeis);
            }
            $this->command->info("  + Serveis assignats a les habitacions del hotel: $hotel->nom");
            Log::info("Serveis assignats a les habitacions del hotel", ['hotel_id' => $hotel->id]);
        }
    }
}
