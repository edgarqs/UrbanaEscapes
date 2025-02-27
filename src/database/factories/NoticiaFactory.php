<?php

namespace Database\Factories;

use App\Models\Noticia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Noticia>
 */
class NoticiaFactory extends Factory
{
    protected $model = Noticia::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titol' => $this->faker->sentence(3),
            'descripcio_curta' => $this->faker->sentence(6),
            'descripcio_llarga' => $this->faker->paragraph(3),
            'publicada' => $this->faker->boolean,
        ];
    }
}
