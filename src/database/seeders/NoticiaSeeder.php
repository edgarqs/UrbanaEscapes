<?php

namespace Database\Seeders;

use App\Models\Noticia;
use App\Models\Hotel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NoticiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $num_noticies = $this->command->ask('Quantes notícies vols crear?', 10);

        $noticies = Noticia::factory($num_noticies)->create();

        $hotels = Hotel::all();

        foreach ($noticies as $noticia) {
            foreach ($hotels as $hotel) {
                DB::table('noticies_hotel')->insert([
                    'noticia_id' => $noticia->id,
                    'hotel_id' => $hotel->id,
                ]);
            }
        }

        $this->command->info("S'han creat $num_noticies notícies i s'han assignat a tots els hotels.");
    }
}
