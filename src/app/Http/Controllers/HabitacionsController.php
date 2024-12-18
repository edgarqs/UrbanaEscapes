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

    //? Devuelve la view de detalls-habitacio.blade.php
    public function detalls($id)
    {
        $habitacio = Habitacion::findOrFail($id);
        return view('components.detalls-habitacio', compact('habitacio'));
    }

    public function showRecepcio(Request $request)
    {
        $hotelId = $request->query('id');
        $hotel = Hotel::findOrFail($hotelId);
        $habitacions = Habitacion::where('hotel_id', $hotelId)->get();
        $reservas = Reservas::whereIn('habitacion_id', $habitacions->pluck('id'))->get();
        
        return view('recepcio.home', [
            'hotel' => $hotel,
            'habitacions' => $habitacions,
            'reservas' => $reservas
        ]);
    }
}
