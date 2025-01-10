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

        $habitacionsOcupadesPercentatge = round(($habitacionsOcupades / $habitacionsTotals) * 100);
        $habitacionsLliuresPercentatge = round(($habitacionsLliures / $habitacionsTotals) * 100);

        return view('hotel.home', [
            'hotel' => $hotel,
            'habitacionsOcupades' => $habitacionsOcupades,
            'habitacionsLliures' => $habitacionsLliures,
            'checkinsPendents' => $checkinsPendents,
            'habitacionsTotals' => $habitacionsTotals,
            'habitacionsOcupadesPercentatge' => $habitacionsOcupadesPercentatge,
            'habitacionsLliuresPercentatge' => $habitacionsLliuresPercentatge,
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
            $reserva->estat = 'Checkin';
            $reserva->save();

            $habitacio->estat = 'Ocupada';
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
            $reserva->estat = 'Checkout';
            $reserva->save();

            $habitacio->estat = 'Bloquejada';
            $habitacio->save();
        }

        return redirect()->back()
            ->with('success', 'Check-Out completat correctament per a l\'habitació número ' . $habitacio->numHabitacion);
    }

    public function checkins(Request $request)
    {
        $filters = [
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date'),
            'status' => $request->get('status'),
            'search' => $request->get('search'),
        ];

        $reservas = Reservas::getCheckinsFiltrats($filters);

        return view('hotel.checkins', compact('reservas'));
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
