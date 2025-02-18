<?php

namespace App\Http\Controllers\ApiV2;

use App\Http\Controllers\Controller;
use App\Models\Habitacion;
use App\Models\Reservas;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HabitacionsCercaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Habitacion::query();

        if ($request->has('id')) {
            $query->where('id', $request->input('id'));
        }

        if ($request->has('hotel_id')) {
            $query->where('hotel_id', $request->input('hotel_id'));
        }

        if ($request->has('tipus')) {
            $tipus = explode(',', $request->input('tipus'));
            $query->whereIn('tipus', $tipus);
        }

        if ($request->has('llits')) {
            $query->where('llits', $request->input('llits'));
        }

        if ($request->has('llits_supletoris')) {
            $query->where('llits_supletoris', $request->input('llits_supletoris'));
        }

        if ($request->has('capacitat')) {
            $query->whereRaw('llits + llits_supletoris = ?', [$request->input('capacitat')]);
        }

        if ($request->has('numHabitacion')) {
            $query->where('numHabitacion', $request->input('numHabitacion'));
        }

        if ($request->has('estat')) {
            $query->where('estat', $request->input('estat'));
        }

        $habitacions = $query->get();
        return response()->json($habitacions);
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
        $habitacio = Habitacion::findOrFail($id);
        return response()->json($habitacio);
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

    public function cercaHabitacions(Request $request)
    {
        $dataEntrada = $request->input('data_entrada');
        $dataSortida = $request->input('data_sortida');
        $tipus = $request->input('tipus');
        $capacitat = $request->input('capacitat');
        $hotelId = $request->input('hotel_id');

        $habitacions = Habitacion::where('hotel_id', $hotelId)
            ->where('tipus', $tipus)
            ->whereRaw('llits + llits_supletoris = ?', [$capacitat])
            ->whereDoesntHave('reservas', function ($query) use ($dataEntrada, $dataSortida) {
                $query->where(function ($query) use ($dataEntrada, $dataSortida) {
                    $query->where('estat', 'Reservada')
                        ->orWhere('estat', 'Checkin');
                })
                ->where(function ($query) use ($dataEntrada, $dataSortida) {
                    $query->whereBetween('data_entrada', [$dataEntrada, $dataSortida])
                        ->orWhereBetween('data_sortida', [$dataEntrada, $dataSortida])
                        ->orWhere(function ($query) use ($dataEntrada, $dataSortida) {
                            $query->where('data_entrada', '<=', $dataEntrada)
                                ->where('data_sortida', '>=', $dataSortida);
                        });
                });
            })
            ->get();

        return response()->json($habitacions);
    }
}
