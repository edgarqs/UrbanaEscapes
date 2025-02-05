<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Exception;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use Illuminate\Support\Facades\Log;
use App\Models\Habitacion;

class Reservas extends Model
{
    use HasFactory;

    protected $fillable = [
        'habitacion_id',
        'usuari_id',
        'data_entrada',
        'data_sortida',
        'preu_total',
        'estat',
        'comentaris'
    ];

    protected $casts = [
        'data_entrada' => 'datetime',
        'data_sortida' => 'datetime',
    ];

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class);
    }

    public function usuari()
    {
        return $this->belongsTo(Usuari::class);
    }
}
