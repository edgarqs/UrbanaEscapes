<?php

namespace Database\Seeders;

use App\Models\Habitacion;
use App\Models\Reservas;
use App\Models\Serveis;
use App\Models\Usuari;
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
        $hotel = \App\Models\Hotel::create(['nom' => 'The Kyoto', 'adreca' => 'Carrer Mariner, 32', 'ciutat' => 'Madrid', 'pais' => 'Espanya', 'email' => 'info@thekyoto.urbanaescapes.com', 'telefon' => '+34 934 56 78 90']);
        $this->command->info("  + Creat hotel de proves $hotel->nom, $hotel->adreca");
        Log::info("Creat hotel de proves", ['hotel' => $hotel]);

        $hotel = \App\Models\Hotel::create(['nom' => 'Hotel Oasis Khartoum', 'adreca' => 'Al-Mogran Street', 'ciutat' => 'Khartoum', 'pais' => 'Sudan', 'email' => 'info@khartoum.urbanaescapes.sd', 'telefon' => '+249 912 345 678']);
        $this->command->info("  + Creat hotel de proves $hotel->nom, $hotel->adreca");
        Log::info("Creat hotel de proves", ['hotel' => $hotel]);

        // Mostrar los hoteles y sus IDs para que el usuario pueda seleccionar uno
        $hotels = \App\Models\Hotel::all();
        $this->command->info("Selecciona un hotel:");

        foreach ($hotels as $hotel) {
            $this->command->info("ID: $hotel->id - Nom: $hotel->nom");
        }

        $hotelSeleccionat = $this->command->ask('Quin hotel vols seleccionar? (Introduce l\'ID)', 1);
        //? Verificar que l'hotel sel·lecionat existe
        $hotelSeleccionat = \App\Models\Hotel::find($hotelSeleccionat);
        if (!$hotelSeleccionat) {
            $this->command->error("L'ID seleccionat no existeix. Intenta de nou.");
            return; //? Para l'execució del seeder si no existeix
        }
        //? Continuar amb la creació de les habitacions si l'hotel existeix
        $this->command->info("Has seleccionat el hotel: $hotelSeleccionat->nom");

        //Creació habitacions
        $habitacionsNumber = $this->command->ask('Quantes habitacions vols crear?', 100);
        Habitacion::factory($habitacionsNumber)->create(
            [
                'hotel_id' => $hotelSeleccionat
            ]
        );
        //? Log de la creació de les habitacions
        $this->command->info("  + Afegides $habitacionsNumber habitacions");
        Log::info("Habitacions afegides", [
            'hotel_id' => $hotelSeleccionat,
            'habitacions_number' => $habitacionsNumber
        ]);

        // Creació usuaris
        $usuarisNumber = $this->command->ask('Quants usuaris vols crear?', 50);
        Usuari::factory($usuarisNumber)->create();
        $this->command->info("  + Afegits $usuarisNumber usuari(s)");
        Log::info("Afegits usuaris", ['usuarisNumber' => $usuarisNumber]);

        // Creació serveis
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

        //Asignacio serveis a habitacions
        $habitacions = Habitacion::all();
        $serveis = Serveis::all();
        foreach ($habitacions as $habitacio) {
            $randomServeis = $serveis->random(min($serveis->count(), rand(0, 5)))->pluck('id');
            if ($randomServeis->isNotEmpty()) {
                $habitacio->serveis()->attach($randomServeis);
            }
        }
        $this->command->info("  + Serveis assignats a les habitacions");

        // Creació reserves
        $reservesNumber = (int) $this->command->ask('Quantes reserves vols crear?', 50);
        Reservas::factory($reservesNumber)->create();

        $this->command->info("  + Afegides $reservesNumber reserves");
        Log::info("Afegides reserves", ['reservesNumber' => $reservesNumber]);
    }

    // Crea les habitacions al crear l'hotel amb el formulari
    public function HabitacionsSedder($hotel_id)
    {
        $habitacionsNumber = 100;
        Habitacion::factory($habitacionsNumber)->create(
            [
                'hotel_id' => $hotel_id
            ]
        );
        Log::info("Afegides habitacions", ['habitacionsNumber' => $habitacionsNumber]);

        // Creació serveis
        //Asignacio serveis a habitacions
        $habitacions = Habitacion::all();
        $serveis = Serveis::all();
        foreach ($habitacions as $habitacio) {
            $randomServeis = $serveis->random(min($serveis->count(), rand(0, 5)))->pluck('id');
            if ($randomServeis->isNotEmpty()) {
                $habitacio->serveis()->attach($randomServeis);
            }
        }
    }
}
