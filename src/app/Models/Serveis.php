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


    public function habitacions()
    {
        return $this->belongsToMany(Habitacion::class, 'habitacion_serveis', 'serveis_id', 'habitacions_id');
    }


    public static function preuTotalServeisPerHabitacio($habitacio_id)
    {
        $serveis = Serveis::select('serveis.preu')
            ->join('habitacion_serveis', 'serveis.id', '=', 'habitacion_serveis.serveis_id')
            ->where('habitacion_serveis.habitacions_id', $habitacio_id)
            ->get();

        $preuTotal = 0;
        foreach ($serveis as $servei) {
            $preuTotal += $servei->preu;
        }
        return $preuTotal;
    }
}
