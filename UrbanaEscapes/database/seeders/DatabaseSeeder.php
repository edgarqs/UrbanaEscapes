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
        $hotel1 = \App\Models\Hotel::create(['nom' => 'The Kyoto', 'adreca' => 'Carrer Mariner, 32', 'ciutat' => 'Madrid', 'pais' => 'Espanya', 'email' => 'info@thekyoto.urbanaescapes.com', 'telefon' => '+34 934 56 78 90']);
        $this->command->info("  + Creat hotel de proves $hotel1->nom, $hotel1->adreca");
        Log::info("Creat hotel de proves", ['hotel' => $hotel1]);

        $hotel2 = \App\Models\Hotel::create(['nom' => 'Hotel Oasis Khartoum', 'adreca' => 'Al-Mogran Street', 'ciutat' => 'Khartoum', 'pais' => 'Sudan', 'email' => 'info@khartoum.urbanaescapes.sd', 'telefon' => '+249 912 345 678']);
        $this->command->info("  + Creat hotel de proves $hotel2->nom, $hotel2->adreca");
        Log::info("Creat hotel de proves", ['hotel' => $hotel2]);

        // Mostrar los hoteles y proceder con la creación de habitaciones, usuarios y reservas para cada uno
        $hotels = \App\Models\Hotel::all();
        foreach ($hotels as $hotel) {
            $this->command->info("Factory Hotel: $hotel->nom");

            // Creación de habitaciones para cada hotel
            $habitacionsNumber = $this->command->ask('Quantes habitacions vols crear per al hotel ' . $hotel->nom . '?', 100);
            Habitacion::factory($habitacionsNumber)->create([
                'hotel_id' => $hotel->id
            ]);
            $this->command->info("  + Afegides $habitacionsNumber habitacions al hotel: $hotel->nom");
            Log::info("Habitacions afegides", ['hotel_id' => $hotel->id, 'habitacions_number' => $habitacionsNumber]);

            // Creación de usuarios
            $usuarisNumber = $this->command->ask('Quants usuaris vols crear per al hotel ' . $hotel->nom . '?', 50);
            Usuari::factory($usuarisNumber)->create();
            $this->command->info("  + Afegits $usuarisNumber usuari(s) al hotel: $hotel->nom");
            Log::info("Afegits usuaris", ['usuarisNumber' => $usuarisNumber, 'hotel_id' => $hotel->id]);

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
            $habitacions = Habitacion::where('hotel_id', $hotel->id)->get();
            $serveis = Serveis::all();
            foreach ($habitacions as $habitacio) {
                $randomServeis = $serveis->random(min($serveis->count(), rand(0, 5)))->pluck('id');
                if ($randomServeis->isNotEmpty()) {
                    $habitacio->serveis()->attach($randomServeis);
                }
            }
            $this->command->info("  + Serveis assignats a les habitacions del hotel: $hotel->nom");

            // Creació reserves
            $reservesNumber = (int) $this->command->ask('Quantes reserves vols crear?', 50);

            // El código para crear las reservas no debe incluir el 'hotel_id', ya que ya se gestiona a través de 'habitacion_id'
            Reservas::factory($reservesNumber)->create();

            // Al finalizar, muestra el mensaje de éxito
            $this->command->info("  + Afegides $reservesNumber reserves");
            Log::info("Afegides reserves", ['reservesNumber' => $reservesNumber]);
        }
    }

    // Crea les habitacions al crear l'hotel amb el formulari
    public function HabitacionsSedder($hotel_id)
    {
        // Crear 100 habitaciones para el hotel
        $habitacionsNumber = 100;
        Habitacion::factory($habitacionsNumber)->create(
            [
                'hotel_id' => $hotel_id
            ]
        );
        Log::info("Afegides habitacions", ['habitacionsNumber' => $habitacionsNumber]);

        // Crear los servicios y asignarlos a las habitaciones del hotel
        $habitacions = Habitacion::where('hotel_id', $hotel_id)->get();
        $serveis = Serveis::all();
        foreach ($habitacions as $habitacio) {
            $randomServeis = $serveis->random(min($serveis->count(), rand(0, 5)))->pluck('id');
            if ($randomServeis->isNotEmpty()) {
                $habitacio->serveis()->attach($randomServeis);
            }
        }
        Log::info("Serveis assignats a les habitacions", ['hotel_id' => $hotel_id]);

        // Crear reservas para las habitaciones de este hotel
        $reservesNumber = 50; // o puedes hacerlo dinámico dependiendo de tu necesidad
        $habitacions = Habitacion::where('hotel_id', $hotel_id)->get();

        foreach ($habitacions as $habitacio) {
            for ($i = 0; $i < $reservesNumber; $i++) {
                // Puedes definir la lógica de las fechas y precios de la reserva
                Reservas::create([
                    'habitacion_id' => $habitacio->id,
                    'usuari_id' => Usuari::inRandomOrder()->first()->id,
                    'data_entrada' => now()->addDays(rand(1, 30)),
                    'data_sortida' => now()->addDays(rand(31, 60)),
                    'preu_total' => rand(50, 200),
                    'estat' => 'finalizada',
                ]);
            }
        }

        Log::info("Afegides reserves", ['hotel_id' => $hotel_id, 'reservesNumber' => $reservesNumber]);
    }
}
