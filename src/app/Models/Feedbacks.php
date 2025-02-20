<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedbacks extends Model
{
    protected $fillable = ['reserva_id', 'estrelles', 'comentari'];

    public function fotos()
    {
        return $this->hasMany(FotosFeedback::class, 'feedback_id');
    }
}
