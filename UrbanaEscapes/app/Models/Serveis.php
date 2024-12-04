<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Habitacion;

class Serveis extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'preu'
    ];


    public function habitacions()
    {
        return $this->belongsToMany(Habitacion::class, 'habitacion_serveis', 'serveis_id', 'habitacions_id');
    }

}
