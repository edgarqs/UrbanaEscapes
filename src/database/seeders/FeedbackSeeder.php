<?php

namespace Database\Seeders;

use App\Models\Feedback;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FeedbackSeeder extends Seeder
{
    public function run()
    {
        Feedback::factory(50)->create(); // Crea 50 feedbacks de prueba
    }
}
