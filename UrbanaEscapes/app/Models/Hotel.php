<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
}
