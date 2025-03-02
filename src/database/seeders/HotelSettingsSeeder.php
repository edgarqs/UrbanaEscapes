<?php

namespace Database\Seeders;

use App\Models\HotelSetting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HotelSettingsSeeder extends Seeder
{
    public function run()
    {
        HotelSetting::create([
            'hotel_id' => 1,
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
    }
}
