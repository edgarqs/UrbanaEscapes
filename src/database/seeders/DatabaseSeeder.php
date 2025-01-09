<?php

namespace Database\Seeders;

use App\Models\Habitacion;
use Database\Seeders\ReservasSeeder;
use Database\Seeders\ServeisSeeder;
use Database\Seeders\UsersSeeder;
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
            Log::channel('info_log')->info("S'ha reconstruït la base de dades");
        }

        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ServeisSeeder::class);
    }
    public function CreateHotelSedder($hotel_id, $num_clients, $num_habitacions, $num_reserves)
    {

        // Crear usuarios adicionales si es necesario
        Usuari::factory($num_clients)->create([
            'hotel_id' => $hotel_id,
        ]);
        Log::channel('info_log')->info("Afegits clients", ['num_clients' => $num_clients]);

        // Crear habitaciones
        $num_habitacio = 1;
        for ($i = 0; $i < $num_habitacions; $i++) {
            Habitacion::factory()->create([
                'hotel_id' => $hotel_id,
                'numHabitacion' => $num_habitacio++
            ]);
        }
        Log::channel('info_log')->info("Afegides habitacions", ['habitacionsNumber' => $num_habitacions]);

        // Creació serveis
        // Asignacio serveis a habitacions
        $habitacions = Habitacion::where('hotel_id', $hotel_id)->get();
        $serveis = Serveis::all();
        foreach ($habitacions as $habitacio) {
            $randomServeis = $serveis->random(min($serveis->count(), rand(0, 5)))->pluck('id');
            if ($randomServeis->isNotEmpty()) {
                $habitacio->serveis()->attach($randomServeis);
            }
        }
        Log::channel('info_log')->info("Serveis assignats a les habitacions del hotel", ['hotel_id' => $hotel_id]);

        // Creació reserves
        Reservas::factory($num_reserves)->create();
        Log::channel('info_log')->info("Afegides reserves", ['reservesNumber' => $num_reserves, 'hotel_id' => $hotel_id]);

        // Creació usuari recepcionista
        $recepcionista = Usuari::factory()->create([
            'hotel_id' => $hotel_id,
            'nom' => 'recepcio' . $hotel_id,
            'password' => bcrypt('recepcio' . $hotel_id),
            'email' => NULL,
            'rol_id' => 2
        ]);
        Log::channel('info_log')->info("Afegit usuari recepcionista", ['hotel_id' => $hotel_id, 'usuari_id' => $recepcionista->id]);
        
    }
}
