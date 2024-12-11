<?php

namespace Database\Seeders;

use App\Models\Reservas;
use Illuminate\Support\Facades\Log;

class ReservasSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        // Creación de reservas
        $reservasNumber = $this->command->ask('Quantes reserves vols crear?', 100);
        Reservas::factory($reservasNumber)->create();
        $this->command->info("  + Afegides $reservasNumber reserves");
        Log::channel('info_log')->info("Reserves afegides", ['reservasNumber' => $reservasNumber]);
    }
}