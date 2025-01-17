<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Usuari;
use App\Models\Reservas;
use App\Models\Habitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\User;

class HabitacionsController extends Controller
{
    public function index($idHotel)
    {
        $habitacions = Habitacion::where('hotel_id', $idHotel)->paginate(10);

        return view('hotel.habitacions', [
            'habitacions' => $habitacions,
            'idHotel' => $idHotel
        ]);
    }

    //? Devuelve la view de detalls-habitacio.blade.php
    public function detalls($id)
    {
        $habitacio = Habitacion::findOrFail($id);
        $reserves = Reservas::where('habitacion_id', $id)->get();
        return view('components.detalls-habitacio', [
            'habitacio' => $habitacio,
            'reserves' => $reserves
        ]);
    }

    public function showRecepcio(Request $request)
    {
        $hotelId = $request->query('id');
        $hotel = Hotel::findOrFail($hotelId);
        $habitacions = Habitacion::where('hotel_id', $hotelId)->get();
        $reserva = Reservas::whereIn('habitacion_id', $habitacions->pluck('id'))->get();
        $reserves = $this->getReservasByDate($hotelId, now());

        return view('recepcio.home', [
            'hotel' => $hotel,
            'habitacions' => $habitacions,
            'reserva' => $reserva,
            'reserves' => $reserves
        ]);
    }

    public function refreshCalendar(Request $request)
    {
        $startDate = $request->query('start_date');
        $hotelId = $request->query('id');

        $habitacions = Habitacion::where('hotel_id', $hotelId)->get();
        $reservas = $this->getReservasByDate($hotelId, $startDate);
        $usuaris = Usuari::all();

        

        return response()->json([
            'habitacions' => $habitacions,
            'reservas' => $reservas,
            'usuaris' => $usuaris,
            'startDate' => $startDate
        ]);
    }

    private function getReservasByDate($hotelId, $startDate)
    {
        $startDate = \Carbon\Carbon::parse($startDate);
        $endDate = $startDate->copy()->addDays(30);

        return Reservas::whereHas('habitacion', function ($query) use ($hotelId) {
            $query->where('hotel_id', $hotelId);
        })
            ->whereDate('data_entrada', '<=', $endDate)
            ->whereDate('data_sortida', '>=', $startDate)
            ->get();
    }

    public function checkin(Request $request, $id)
    {
        $habitacio = Habitacion::findOrFail($id);
        $reserva = $habitacio->reservas()->where('estat', 'Reservada')->orderBy('data_entrada')->first();

        if ($reserva && $habitacio->estat === 'Lliure') {
            $reserva->estat = 'Checkin';
            $reserva->save();

            $habitacio->estat = 'Ocupada';
            $habitacio->save();

            return redirect()->back()->with('success', 'Check-In completat correctament per a l\'habitació número ' . $habitacio->numHabitacion);
        }

        return redirect()->back()->with('error', 'No s\'ha pogut completar el Check-In.');
    }

    public function checkout(Request $request, $id)
    {
        $habitacio = Habitacion::findOrFail($id);
        $reserva = $habitacio->reservas()->where('estat', 'Checkin')->first();

        if ($reserva && $habitacio->estat === 'Ocupada') {
            $reserva->estat = 'Checkout';
            $reserva->save();

            $habitacio->estat = 'Lliure';
            $habitacio->save();

            return redirect()->back()->with('success', 'Check-Out completat correctament per a l\'habitació número ' . $habitacio->numHabitacion);
        }

        return redirect()->back()->with('error', 'No s\'ha pogut completar el Check-Out.');
    }
}
