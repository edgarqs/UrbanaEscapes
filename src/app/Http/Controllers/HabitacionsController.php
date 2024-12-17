<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Reservas;

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

        return redirect()->back()->with('success', 'Check-In completat correctament per a l\'habitació número ' . $habitacio->numHabitacion);
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

        return redirect()->back()->with('success', 'Check-Out completat correctament per a l\'habitació número ' . $habitacio->numHabitacion);
    }

    public function showRecepcio(Request $request)
    {
        $hotelId = $request->query('id');
        $hotel = Hotel::findOrFail($hotelId);
        $habitacions = Habitacion::where('hotel_id', $hotelId)->get();
        $reservas = Reservas::whereIn('habitacion_id', $habitacions->pluck('id'))->get();
        

        \Carbon\Carbon::setLocale('ca');
        $today = \Carbon\Carbon::today();
        $startDate = $today->copy()->subDays(5);
        $endDate = $today->copy()->addDays(26);


        
        return view('recepcio.home', [
            'hotel' => $hotel,
            'habitacions' => $habitacions,
            'reservas' => $reservas,
            'startDate' =>$startDate,
            'endDate' => $endDate
        ]);
    }
}
