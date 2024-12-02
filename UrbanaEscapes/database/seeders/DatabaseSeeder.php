<?php

namespace Database\Seeders;

use App\Models\Habitacion;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
        }

        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $hotel = \App\Models\Hotel::create(['nom' => 'The Kyoto', 'adreca' => 'Carrer Mariner, 32', 'ciutat' => 'Madrid', 'pais' => 'Espanya', 'email' => 'info@thekyoto.urbanaescapes.com', 'telefon' => '934567890']);
        $this->command->info("  + Creat hotel de proves $hotel->nom, $hotel->adreca");

        $serveis = [
            [
                'nom' => 'Minibar',
            ],
            [
                'nom' => 'Cafetera',
            ],
            [
                'nom' => 'Microones',
            ],
            [
                'nom' => 'Smart TV',
            ],
            [
                'nom' => 'Mascotas',
            ]
        ];

        // $serveis = array_map(fn($nom) => ['nom' => $nom], [
        //     'Minibar', 'Cafetera', 'Microones', 'Smart TV', 'Mascotas'
        // ]);

        // Importar les dades a la base de dades
        DB::table('serveis')->insert($serveis);

        $this->command->info("  + Afegit els servis a la taula serveis");

        \App\Models\Usuari::factory(50)->create();

        Habitacion::factory(50)->create();
    }
}

