<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedbacks extends Model
{
    protected $fillable = ['reserva_id', 'estrelles', 'comentari'];

    public function reserva()
    {
        return $this->belongsTo(Reservas::class, 'reserva_id');
    }
}
