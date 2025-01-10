<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    public static function getCheckinsFiltrats($filters)
    {
        $query = self::query();

        $filterConditions = [
            'start_date' => fn($query, $value) => $query->whereDate('data_entrada', '>=', $value),
            'end_date' => fn($query, $value) => $query->whereDate('data_sortida', '<=', $value),
            'status' => fn($query, $value) => $query->whereHas('habitacion', fn($q) => $q->where('estat', $value)),
            'search' => fn($query, $value) => $query->where(function ($q) use ($value) {
                $q->whereHas('usuari', fn($q2) => $q2->where('nom', 'like', "%$value%"))
                    ->orWhere('id', 'like', "%$value%");
            }),
        ];

        foreach ($filters as $key => $value) {
            if (!empty($value) && isset($filterConditions[$key])) {
                $filterConditions[$key]($query, $value);
            }
        }

        return $query->get();
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

    public static function calcularPreuTotal($serveis, $habitacio,$diaInicial, $diaFinal)
    {
        $preuTotal = 0;
        $preuPerDia = $habitacio->preu;
        $dataInici = new Datetime($diaInicial);
        $dataFi = new Datetime($diaFinal);
        $diesTotal = $dataInici->diff($dataFi)->days;
        foreach ($serveis as $serveiId) {
            $servei = Serveis::find($serveiId);
            $preuPerDia += $servei->preu ;
        }
        $preuTotal += $preuPerDia * $diesTotal;
        return $preuTotal;
    }
}
