<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'adreca',
        'ciutat',
        'pais',
        'email',
        'telefon',
    ];

    public function habitacions()
    {
        return $this->hasMany(Habitacion::class);
    }

    public function reserves()
    {
        return $this->hasMany(Reservas::class);
    }

    public function usuaris()
    {
        return $this->hasMany(Usuari::class);
    }

    public function toggleComplete()
    {
        $this->completado = !$this->completado;
        $this->save();

        Log::info('Hotel afegit correctament', [
            'hotel_id' => $this->id,
            'completado' => $this->completado,
        ]);
    }
}
