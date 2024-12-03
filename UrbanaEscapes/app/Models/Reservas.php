<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservas extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'habitacion_id',
        'usuari_id',
        'data_entrada',
        'data_sortida',
        'preu_total',
        'estat'
    ];

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class);
    }

    public function usuari()
    {
        return $this->belongsTo(Usuari::class);
    }

    public static function countHabitacionesLliures($hotelId)
    {
        return Habitacion::whereDoesntHave('reservas')->where('hotel_id', $hotelId)->count();
    }

    public static function countHabitacionesPendientes($hotelId)
    {
        return Habitacion::whereHas('reservas', function($query) {
            $query->where('estat', 'pendent');
        })->where('hotel_id', $hotelId)->count();
    }

    public static function countHabitacionesConfirmadas($hotelId)
    {
        return Habitacion::whereHas('reservas', function($query) {
            $query->where('estat', 'confirmada');
        })->where('hotel_id', $hotelId)->count();
    }
}