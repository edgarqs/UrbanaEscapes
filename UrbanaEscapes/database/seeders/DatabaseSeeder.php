<?php

namespace Database\Seeders;

use App\Models\Habitacion;
use App\Models\Reservas;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // Para usar DB::

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    if ($this->command->confirm('Vols refrescar la base de dades?', true)) {
        $this->command->call('migrate:refresh');
        $this->command->info("S'ha reconstruït la base de dades");
        Log::info("S'ha reconstruït la base de dades");
    }

    // Creació d'hotels
    $hotel = \App\Models\Hotel::create(['nom' => 'The Kyoto', 'adreca' => 'Carrer Mariner, 32', 'ciutat' => 'Madrid', 'pais' => 'Espanya', 'email' => 'info@thekyoto.urbanaescapes.com', 'telefon' => '934567890']);
    $this->command->info("  + Creat hotel de proves $hotel->nom, $hotel->adreca");
    Log::info("Creat hotel de proves", ['hotel' => $hotel]);

    // Creació habitacions
    $habitacionsNumber = $this->command->ask('Quantes habitacions vols crear?', 100);
    $habitacions = Habitacion::factory($habitacionsNumber)->create();
    $this->command->info("  + Afegides $habitacionsNumber habitacions");
    Log::info("Afegides habitacions", ['habitacionsNumber' => $habitacionsNumber]);

    // Creació usuaris
    $usuarisNumber = $this->command->ask('Quants usuaris vols crear?', 50);
    \App\Models\Usuari::factory($usuarisNumber)->create();
    $this->command->info("  + Afegits $usuarisNumber usuari(s)");
    Log::info("Afegits usuaris", ['usuarisNumber' => $usuarisNumber]);

    // Creació de serveis
    $serveis = [
        ['nom' => 'Minibar'],
        ['nom' => 'Cafetera'],
        ['nom' => 'Microones'],
        ['nom' => 'Smart TV'],
        ['nom' => 'Mascotas']
    ];

    DB::table('serveis')->insert($serveis);
    $this->command->info("  + Afegits els serveis");
    Log::info("Afegits els serveis", ['serveis' => $serveis]);

    // Creació reserves
    $reservesNumber = $this->command->ask('Quantes reserves vols crear?', 50);
    Reservas::factory($reservesNumber)->create();
    $this->command->info("  + Afegides $reservesNumber reserves");
    Log::info("Afegides reserves", ['reservesNumber' => $reservesNumber]);
}
}

