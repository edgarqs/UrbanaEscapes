<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class StartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if ($this->command->confirm('Vols refrescar la base de dades?', true)) {
            $this->command->call('migrate:refresh');
            $this->command->info("S'ha reconstruït la base de dades");
            Log::channel('info_log')->info("S'ha reconstruït la base de dades");
        }

        $this->call(HotelSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(HabitacionsSeeder::class);
        $this->call(ServeisSeeder::class);
        $this->call(ReservasSeeder::class);
    }
}
