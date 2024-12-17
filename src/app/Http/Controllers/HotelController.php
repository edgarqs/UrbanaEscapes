<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Database\Seeders\DatabaseSeeder;
use App\Models\Habitacion;
use App\Models\Reservas;

class HotelController extends Controller
{
    
    public function index()
    {
        $hotels = Hotel::all();
        return view('hotel.selector', ['hotels' => $hotels]);
    }
    public function create()
    {
        return view('hotel.create');
    }
    public function guardarHotel(Request $request)
    {
        $dades = $request->validate([
            'nom' => 'required|string|max:30',
            'adreca' => 'required|string|max:40',
            'ciutat' => 'required|string|max:50',
            'pais' => 'required|string|max:23',
            'email' => 'required|email|max:50',
            'telefon' => 'required|string|max:15',
        ]);
 
        $hotel = Hotel::create($dades);

        $seederHabitacions = new DatabaseSeeder();
        $seederHabitacions->CreateHotelSedder($hotel->id);
        

        return redirect()->route('hotel.selector')->with('status', 'Hotel creat correctament');
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
