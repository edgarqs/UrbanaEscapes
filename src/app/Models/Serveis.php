<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Habitacion;
use Illuminate\Support\Facades\Log;

class Serveis extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'preu'
    ];


    public function reservas()
    {
        return $this->belongsToMany(Habitacion::class, 'reservas_serveis', 'serveis_id', 'reservas_id');
    }


    public static function preuTotalServeisPerHabitacio($reserva_id)
    {
        $serveis = Serveis::select('serveis.preu')
            ->join('reservas_serveis', 'serveis.id', '=', 'reservas_serveis.serveis_id')
            ->where('reservas_serveis.reservas_id', $reserva_id)
            ->get();

        $preuTotal = 0;
        foreach ($serveis as $servei) {
            $preuTotal += $servei->preu;
        }
        
        Log::channel('info_log')->info('Preu total dels serveis per habitació', ['reservas_id' => $reserva_id, 'preu_total' => $preuTotal]);

        return $preuTotal;
    }
}
