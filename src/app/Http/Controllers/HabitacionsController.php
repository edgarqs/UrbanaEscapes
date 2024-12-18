<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use Illuminate\Http\Request;

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
}
