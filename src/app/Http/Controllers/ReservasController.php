<?php

namespace App\Http\Controllers;

use App\Models\Reservas;
use Illuminate\Http\Request;
use App\Models\Habitacion;

class ReservasController extends Controller
{
    public function home(Request $request)
    {
        $id = $request->query('id');

        $habitacionsOcupades = Reservas::countHabitacionesConfirmadas($id);
        $habitacionsLliures = Reservas::countHabitacionesLliures($id);
        $checkinsPendents = Reservas::countReservasPendientes($id);
        $habitacionsTotals = Reservas::getHabitacionesTotals($id);

        return view('hotel.home', [
            'habitacionsOcupades' => $habitacionsOcupades,
            'habitacionsLliures' => $habitacionsLliures,
            'checkinsPendents' => $checkinsPendents,
            'habitacionsTotals' => $habitacionsTotals
        ]);
    }

    public function habitacions(Request $request)
    {
        $paginacioHabitacions = env('PAGINACIO_HABITACIONS', 100);
        $idHotel = $request->query('id');
        $habitacions = Habitacion::where('hotel_id', $idHotel)->paginate($paginacioHabitacions);
    
        return view('hotel.habitacions', ['idHotel' => $idHotel, 'habitacions' => $habitacions]);
    }
}
