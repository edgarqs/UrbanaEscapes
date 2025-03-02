<?php

namespace Database\Seeders;

use App\Models\Usuari;
use App\Models\Serveis;
use App\Models\Reservas;
use App\Models\Feedbacks;
use App\Models\Habitacion;
use Faker\Factory as Faker;
use App\Models\HotelSetting;
use Illuminate\Database\Seeder;
use Database\Seeders\HotelSeeder;
use Database\Seeders\UsersSeeder;
use Database\Seeders\ServeisSeeder;
use Illuminate\Support\Facades\Log;
use Database\Seeders\ReservasSeeder;

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
    public function CreateHotelSedder($hotel_id, $num_clients, $num_habitacions, $num_reserves, $num_feedbacks)
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

        // Creació reserves
        Reservas::factory($num_reserves)->create();
        Log::channel('info_log')->info("Afegides reserves", ['reservesNumber' => $num_reserves, 'hotel_id' => $hotel_id]);


        // Asignar serveis a reservas
        $reservas = Reservas::all();
        $serveis = Serveis::all();
        foreach ($reservas as $reserva) {
            $randomServeis = $serveis->random(min($serveis->count(), rand(0, 5)))->pluck('id');
            if ($randomServeis->isNotEmpty()) {
                $reserva->serveis()->attach($randomServeis);
            }
        }
        Log::channel('info_log')->info("Serveis assignats a les habitacions del hotel", ['hotel_id' => $hotel_id]);

        // Creació feedbacks
        $reservasCheckout = Reservas::where('estat', 'Checkout')->pluck('id')->toArray();
        $faker = Faker::create();

        for ($i = 0; $i < $num_feedbacks; $i++) {
            Feedbacks::create([
                'reserva_id' => $faker->randomElement($reservasCheckout),
                'estrelles' => $faker->numberBetween(1, 5),
                'comentari' => $faker->sentence,
            ]);
        }
        Log::channel('info_log')->info("Afegits feedbacks", ['feedbacksNumber' => $num_feedbacks]);

        // Creació usuari recepcionista
        $recepcionista = Usuari::factory()->create([
            'hotel_id' => $hotel_id,
            'nom' => 'recepcio' . $hotel_id,
            'password' => bcrypt('recepcio' . $hotel_id),
            'email' => NULL,
            'dni' => NULL,
            'rol_id' => 2
        ]);
        Log::channel('info_log')->info("Afegit usuari recepcionista", ['hotel_id' => $hotel_id, 'usuari_id' => $recepcionista->id]);

        // Crear configuración del hotel
        HotelSetting::create([
            'hotel_id' => $hotel_id,
            'secciones_visibles' => [
                'buscador' => true,
                'habitacions' => true,
                'feedbacks' => true,
                'noticies' => true
            ],
            'secciones_orden' => ["buscador", "habitacions", "feedbacks", "noticies"],
            'noticias_cantidad' => 3,
            'feedbacks_cantidad' => 5
        ]);
        Log::channel('info_log')->info("Configuración del hotel creada", ['hotel_id' => $hotel_id]);
    }
}
