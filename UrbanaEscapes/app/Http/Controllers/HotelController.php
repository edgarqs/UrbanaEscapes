<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Database\Seeders\DatabaseSeeder;

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
            'nom' => 'required',
            'adreca' => 'required',
            'ciutat' => 'required',
            'pais' => 'required',
            'email' => 'required',
            'telefon' => 'required',
        ]);

        $hotel = Hotel::create($dades);


        $seederHabitacions = new DatabaseSeeder();
        $seederHabitacions->HabitacionsSedder($hotel->id);
        

        return redirect()->route('hotel.selector')->with('success', 'Hotel creat correctament');
    }
}
