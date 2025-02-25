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
        return $this->belongsTo(Habitacion::class, 'habitacion_id');
    }

    public function serveis()
    {
        return $this->belongsToMany(Serveis::class, 'reservas_serveis', 'reservas_id', 'serveis_id');
    }

    public function usuari()
    {
        return $this->belongsTo(Usuari::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedbacks::class, 'reserva_id');
    }

    // Habitacions ocupades
    public static function countHabitacionesConfirmadas($hotelId)
    {
        $count = Habitacion::where('estat', 'Ocupada')->where('hotel_id', $hotelId)->count();
        Log::channel('info_log')->info('Comptador d\'habitacions confirmades', ['hotel_id' => $hotelId, 'count' => $count]);
        return $count;
    }

    // Habitacions lliures
    public static function countHabitacionesLliures($hotelId)
    {
        $count = Habitacion::where('estat', 'Lliure')->where('hotel_id', $hotelId)->count();
        Log::channel('info_log')->info('Comptador d\'habitacions lliures', ['hotel_id' => $hotelId, 'count' => $count]);
        return $count;
    }

    public static function countHabitacionesBloquejades($hotelId)
    {
        $count = Habitacion::where('estat', 'Bloquejada')->where('hotel_id', $hotelId)->count();
        Log::channel('info_log')->info('Comptador d\'habitacions bloquejades', ['hotel_id' => $hotelId, 'count' => $count]);
        return $count;
    }

    // Reserves amb estat "reservada"
    public static function countReservasPendientes($hotelId)
    {
        $count = Reservas::whereHas('habitacion', function ($query) use ($hotelId) {
            $query->where('hotel_id', $hotelId);
        })->where('estat', 'Reservada')->count();

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

    public static function getCheckinsPendents($hotelId)
    {
        return Reservas::whereHas('habitacion', function ($query) use ($hotelId) {
            $query->where('hotel_id', $hotelId);
        })
            ->where('estat', 'Reservada')
            ->orderBy('id')
            ->get();
    }

    public static function calcularPreuPerDies($habitacio, $diaActual, $diaSeguent)
    {
        $preuPerDies = 0;
        $dataInici = new Datetime($diaActual);
        $dataFi = new Datetime($diaSeguent);
        $dies = $dataInici->diff($dataFi)->days;
        $preuPerDies = $habitacio->preu * $dies;

        return $preuPerDies;
    }

    public static function calcularPreuTotal($serveis, $habitacio, $diaInicial, $diaFinal)
    {
        $preuTotal = 0;
        if (is_string($habitacio)) {
            $habitacio = Habitacion::find($habitacio);
        }
        $preuPerDia = $habitacio->preu;
        $dataInici = new Datetime($diaInicial);
        $dataFi = new Datetime($diaFinal);
        $diesTotal = $dataInici->diff($dataFi)->days;
        foreach ($serveis as $serveiId) {
            $servei = Serveis::find($serveiId);
            $preuPerDia += $servei->preu;
        }
        $preuTotal += $preuPerDia * $diesTotal;
        return $preuTotal;
    }
}
