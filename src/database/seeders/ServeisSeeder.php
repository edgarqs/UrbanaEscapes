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
    }
}
