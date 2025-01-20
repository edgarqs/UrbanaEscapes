<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'numero',
        'tipo',
        'precio',
        'numHabitacion',
        'estat'
    ];

    public function reservas()
    {
        return $this->hasMany(Reservas::class, 'habitacion_id');
    }
    public function getEstat()
    {
        return $this->estat;
    }

    public function getReservaActual()
    {
        return $this->reservas()->whereDate('data_entrada', '<=', now())
            ->whereDate('data_sortida', '>=', now())->first();
    }

    public static function getTipusHabitacions()
    {
        return Habitacion::select('tipus')->distinct()->get();
    }

    public static function sumaCapacitatLlits($id)
    {
        $llits = Habitacion::select('llits')->where('id', $id)->first()->llits;
        $llitsSupletoris = Habitacion::select('llits_supletoris')->where('id', $id)->first()->llits_supletoris;

        $capacitat = $llits + $llitsSupletoris;
        return $capacitat;
    }
}
