<?php

namespace Database\Seeders;

use App\Models\Reservas;
use Illuminate\Support\Facades\Log;
use App\Models\Usuari;
use App\Models\Hotel;

class UsersSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        $hotel = Hotel::first(); // Obtener el primer hotel
        if ($hotel) {
            $usuarisNumber = $this->command->ask('Quants usuaris vols crear per al hotel ' . $hotel->nom . '?', 50);
            Usuari::factory($usuarisNumber)->create();
            $this->command->info("  + Afegits $usuarisNumber usuari(s) al hotel: $hotel->nom");
            Log::channel('info_log')->info("Afegits usuaris", ['usuarisNumber' => $usuarisNumber, 'hotel_id' => $hotel->id]);
        } else {
            $this->command->error('No s\'ha trobat cap hotel.');
        }
    }
}