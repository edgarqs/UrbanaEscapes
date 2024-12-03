<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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
        $count = Habitacion::whereDoesntHave('reservas')->where('hotel_id', $hotelId)->count();
        Log::info('Comptador d\'habitacions lliures', ['hotel_id' => $hotelId, 'count' => $count]);
        return $count;
    }

    public static function countHabitacionesPendientes($hotelId)
    {
        $count = Habitacion::whereHas('reservas', function ($query) {
            $query->where('estat', 'pendent');
        })->where('hotel_id', $hotelId)->count();
        Log::info('Comptador d\'habitacions pendents', ['hotel_id' => $hotelId, 'count' => $count]);
        return $count;
    }

    public static function countHabitacionesConfirmadas($hotelId)
    {
        $count = Habitacion::whereHas('reservas', function ($query) {
            $query->where('estat', 'confirmada');
        })->where('hotel_id', $hotelId)->count();
        Log::info('Comptador d\'habitacions confirmades', ['hotel_id' => $hotelId, 'count' => $count]);
        return $count;
    }
}
