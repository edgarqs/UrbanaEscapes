<?php

namespace App\Http\Controllers\ApiV2;

use App\Http\Controllers\Controller;
use App\Models\Reservas;
use Illuminate\Http\Request;

class ReservesCercaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Reservas::query();

        if ($request->has('id')) {
            $query->where('id', $request->input('id'));
        }

        if ($request->has('habitacion_id')) {
            $query->where('habitacion_id', $request->input('habitacion_id'));
        }

        if ($request->has('usuari_id')) {
            $query->where('usuari_id', $request->input('usuari_id'));
        }

        if ($request->has('data_entrada')) {
            $query->whereDate('data_entrada', $request->input('data_entrada'));
        }

        if ($request->has('data_sortida')) {
            $query->whereDate('data_sortida', $request->input('data_sortida'));
        }

        if ($request->has('estat')) {
            $query->where('estat', $request->input('estat'));
        }

        $reserves = $query->get();
        return response()->json($reserves);
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
        $reserva = Reservas::findOrFail($id);
        return response()->json($reserva);
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
}
