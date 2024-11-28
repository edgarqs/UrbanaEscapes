<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Habitacion extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'tipus',
        'llits',
        'llits_supletoris',
        'preu',
        'hotel_id',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function reserves()
    {
        return $this->hasMany(Reservas::class);
    }
}
