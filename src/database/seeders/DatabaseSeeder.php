<?php

namespace Database\Seeders;

use App\Models\Habitacion;
use Database\Seeders\ReservasSeeder;
use Database\Seeders\ServeisSeeder;
use Database\Seeders\UsersSeeder;
use Database\Seeders\HabitacionsSedder;
use Database\Seeders\HotelSeeder;
use App\Models\Reservas;
use App\Models\Serveis;
use App\Models\Usuari;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

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

        $this -> call(HotelSeeder::class);
        $this->call(HabitacionsSeeder::class);
        $hotels = \App\Models\Hotel::all();
        foreach ($hotels as $hotel) {
            $this->command->info("Factory Hotel: $hotel->nom");
            
            $this->call(UsersSeeder::class);
            
            $this->call(ServeisSeeder::class);
            $this->call(ReservasSeeder::class);
        }
    }

    // Crea les habitacions al crear l'hotel amb el formulari
    public function CreateHotelSedder($hotel_id)
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
        $habitacions = Habitacion::where('hotel_id', $hotel_id)->get();
        $serveis = Serveis::all();
        foreach ($habitacions as $habitacio) {
            $randomServeis = $serveis->random(min($serveis->count(), rand(0, 5)))->pluck('id');
            if ($randomServeis->isNotEmpty()) {
                $habitacio->serveis()->attach($randomServeis);
            }
        }
        Log::info("Serveis assignats a les habitacions del hotel", ['hotel_id' => $hotel_id]);

        // Creació reserves
        $reservesNumber = 50;
        Reservas::factory($reservesNumber)->create();
        Log::info("Afegides reserves", ['reservesNumber' => $reservesNumber, 'hotel_id' => $hotel_id]);
    }
}
