<?php

namespace App\Http\Controllers\ApiV2;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Habitacion;
use Illuminate\Http\Request;

class HotelsCercaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = Hotel::all();
        return response()->json($hotels);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $hotel = Hotel::where('id', $id)->orWhere('codi_hotel', $id)->firstOrFail();
        return response()->json($hotel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Get unique room types for a specific hotel.
     */
    public function getTiposHabitaciones($id)
    {
        $hotel = Hotel::where('id', $id)->orWhere('codi_hotel', $id)->firstOrFail();
        $tiposHabitaciones = Habitacion::where('hotel_id', $hotel->id)
            ->select('tipus')
            ->distinct()
            ->get();

        return response()->json($tiposHabitaciones);
    }
}
