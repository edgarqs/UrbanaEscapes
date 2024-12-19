<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class);
    }

    public function usuari()
    {
        return $this->belongsTo(Usuari::class);
    }

    // Habitacions ocupades
    public static function countHabitacionesConfirmadas($hotelId)
    {
        $count = Habitacion::where('estat', 'ocupada')->where('hotel_id', $hotelId)->count();
        Log::channel('info_log')->info('Comptador d\'habitacions confirmades', ['hotel_id' => $hotelId, 'count' => $count]);
        return $count;
    }

    // Habitacions lliures
    public static function countHabitacionesLliures($hotelId)
    {
        $count = Habitacion::where('estat', 'lliure')->where('hotel_id', $hotelId)->count();
        Log::channel('info_log')->info('Comptador d\'habitacions lliures', ['hotel_id' => $hotelId, 'count' => $count]);
        return $count;
    }

    // Reserves amb estat "reservada"
    public static function countReservasPendientes($hotelId)
    {
        $count = Reservas::whereHas('habitacion', function ($query) use ($hotelId) {
            $query->where('hotel_id', $hotelId);
        })->where('estat', 'reservada')->count();
        
        Log::channel('info_log')->info('Comptador de reserves pendents', ['hotel_id' => $hotelId, 'count' => $count]);
        return $count;
    }

    // Totes les habitacions
    public static function getHabitacionesTotals($hotelId)
    {
        $habitacions = Habitacion::where('hotel_id', $hotelId)->get()->count();
        Log::channel('info_log')->info('Comptador de totes les habitacions', ['hotel_id' => $hotelId, 'count' => $habitacions]);
        return $habitacions;
    }
}
