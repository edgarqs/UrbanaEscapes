<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Log;
use App\Models\Usuari;
use App\Models\Hotel;
use Illuminate\Support\Facades\Hash;

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

        foreach (Hotel::all() as $hotel) {
            Usuari::create([
                'nom' => 'recepcio' . $hotel->id,
                'email' => null,
                'password' => Hash::make('recepcio'),
                'rol_id' => '2',
                'hotel_id' => $hotel->id,
            ]);
            $this->command->info("  + Afegit recepcionista a l'hotel: $hotel->nom");
            Log::channel('info_log')->info("Afegits usuari(s) recepcionista al hotel", ['hotel_id' => $hotel->id]);
        }

        $usuariAdministrador = Usuari::create([
            'nom' => 'admin',
            'email' => null,
            'password' => Hash::make('admin'),
            'rol_id' => '1',
        ]);
        $this->command->info("  + Creat usuari recepcionista $usuariAdministrador->nom");
        Log::channel('info_log')->info("Afegit usuari administrador", ['usuari' => $usuariAdministrador]);
    }
}
