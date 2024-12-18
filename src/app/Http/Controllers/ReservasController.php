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

    public function checkin($id)
    {
        $habitacio = Habitacion::findOrFail($id);
        $reserva = $habitacio->reservas()->where('estat', 'reservada')->first();

        if ($reserva) {
            $reserva->estat = 'checkin';
            $reserva->save();

            $habitacio->estat = 'ocupada';
            $habitacio->save();
        }

        return redirect()->back()
            ->with('success', 'Check-In completat correctament per a l\'habitació número ' . $habitacio->numHabitacion);
    }


    public function checkout($id)
    {
        $habitacio = Habitacion::findOrFail($id);
        $reserva = $habitacio->reservas()->where('estat', 'checkin')->first();

        if ($reserva) {
            $reserva->estat = 'checkout';
            $reserva->save();

            $habitacio->estat = 'lliure';
            $habitacio->save();
        }

        return redirect()->back()
            ->with('success', 'Check-Out completat correctament per a l\'habitació número ' . $habitacio->numHabitacion);
    }

    public function checkins(Request $request)
    {
        $startDate = $request->query('start_date', now()->startOfDay());
        $endDate = $request->query('end_date', now()->endOfDay());

        $reservas = Reservas::where('estat', 'reservada')
            ->whereBetween('data_entrada', [$startDate, $endDate])
            ->with('usuari', 'habitacion')
            ->get();

        return view('hotel.checkins', [
            'reservas' => $reservas,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }
}
