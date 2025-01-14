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

    public function serveis()
    {
        return $this->belongsToMany(Serveis::class, 'habitacion_serveis', 'habitacions_id', 'serveis_id');
    }

    public static function getHabitacionPreu($habitacion_id)
    {
        $habitacion = Habitacion::select('preu')->where('id', $habitacion_id)->first();
        
        $preuServeis = Serveis::preuTotalServeisPerHabitacio($habitacion_id);
        $preuTotal = $habitacion->preu + $preuServeis;

        Log::channel('info_log')->info('Preu total de la habitació', ['habitacio_id' => $habitacion_id, 'preu_total' => $preuTotal]);

        return $preuTotal;
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


}
