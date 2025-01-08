<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Usuari;
use App\Models\Reservas;
use App\Models\Habitacion;
use Illuminate\Http\Request;

class ReservasController extends Controller
{
    public function home(Request $request)
    {
        $id = $request->query('id');
        $hotel = Hotel::findOrFail($id); //? Busca el hotel amb l'id que li passem per paràmetre

        $habitacionsOcupades = Reservas::countHabitacionesConfirmadas($id);
        $habitacionsLliures = Reservas::countHabitacionesLliures($id);
        $checkinsPendents = Reservas::countReservasPendientes($id);
        $habitacionsTotals = Reservas::getHabitacionesTotals($id);

        return view('hotel.home', [
            'hotel' => $hotel,
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

    public function index($habitacionId)
    {
        $usuaris = Usuari::all();
        $habitacio = Habitacion::findOrFail($habitacionId);
        return view('recepcio.reservas', ['habitacionId' => $habitacionId, 'usuaris' => $usuaris, 'habitacio' => $habitacio]);
    }


    public function store(Request $request, $habitacionId)
    {
        return redirect()->route('recepcio')
            ->with('success', 'Reserva completada correctament');
    }
}
