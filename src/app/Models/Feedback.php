<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'reserva_id',
        'estrelles',
        'comentari',
    ];

    // Relación con la reserva
    public function reserva()
    {
        return $this->belongsTo(Reservas::class, 'reserva_id');
    }
}
