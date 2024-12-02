<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'numero',
        'tipo',
        'precio'
    ];

    public function reservas()
    {
        return $this->hasMany(Reservas::class, 'habitacion_id');
    }
}