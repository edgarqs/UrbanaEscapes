<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();
        return view('hotel.index', ['hotels' => $hotels]);
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

        Hotel::create($dades);
        return redirect()->route('hotel.index')->with('success', 'Hotel creat correctament');
    }
}
