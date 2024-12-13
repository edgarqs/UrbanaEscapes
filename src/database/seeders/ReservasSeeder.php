<?php

namespace Database\Seeders;

use App\Models\Reservas;
use Illuminate\Support\Facades\Log;
use App\Models\Hotel;

class ReservasSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        // Creación de reservas

        $hotels = Hotel::all();

        foreach ($hotels as $hotel) {
            $reservasNumber = $this->command->ask('Quantes reserves vols crear?', 100);
            Reservas::factory($reservasNumber)->create();
            $this->command->info("  + Afegides $reservasNumber reserves al hotel: $hotel->nom");
            Log::channel('info_log')->info("Reserves afegides", ['reservasNumber' => $reservasNumber],);
        }
    }
}
