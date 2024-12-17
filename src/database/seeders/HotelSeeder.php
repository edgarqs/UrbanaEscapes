<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Log;
use App\Models\Hotel;

class HotelSeeder extends DatabaseSeeder
{
    // Creación de hoteles
    public function run(): void
    {
   
    $hotel1 = Hotel::updateOrCreate(['nom' => 'The Kyoto', 'adreca' => 'Carrer Mariner, 32', 'ciutat' => 'Madrid', 'pais' => 'Espanya', 'email' => 'info@thekyoto.urbanaescapes.com', 'telefon' => '+34 934 56 78 90']);
    $this->command->info("  + Creat hotel de proves $hotel1->nom, $hotel1->adreca");
    Log::channel('info_log')->info("Creat hotel de proves", ['hotel' => $hotel1]);

    $hotel2 = Hotel::updateOrCreate(['nom' => 'Hotel Oasis Khartoum', 'adreca' => 'Al-Mogran Street', 'ciutat' => 'Khartoum', 'pais' => 'Sudan', 'email' => 'info@khartoum.urbanaescapes.sd', 'telefon' => '+249 912 345 678']);
    $this->command->info("  + Creat hotel de proves $hotel2->nom, $hotel2->adreca");
    Log::channel('info_log')->info("Creat hotel de proves", ['hotel' => $hotel2]);
}
}