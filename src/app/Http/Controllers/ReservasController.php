<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Reservas;
use Illuminate\Http\Request;
use App\Models\Habitacion;

class ReservasController extends Controller
{
    public function home(Request $request)
    {
        $id = $request->query('id');

        $hab_lliures = Reservas::countHabitacionesLliures($id);
        $hab_pendent = Reservas::countHabitacionesPendientes($id);
        $hab_ocupada = Reservas::countHabitacionesConfirmadas($id);
        $habitacionsTotals = Reservas::getHabitacionesTotals($id);

        return view('hotel.home', [
            'hab_lliures' => $hab_lliures,
            'hab_pendent' => $hab_pendent,
            'hab_ocupada' => $hab_ocupada,
            'habitacionsTotals' => $habitacionsTotals
        ]);
    }

    public function habitacions(Request $request)
    {
        $idHotel = $request->query('id');
        $habitacions = Habitacion::where('hotel_id', $idHotel)->paginate(100);
    
        return view('hotel.habitacions', ['idHotel' => $idHotel, 'habitacions' => $habitacions]);
    }
}
