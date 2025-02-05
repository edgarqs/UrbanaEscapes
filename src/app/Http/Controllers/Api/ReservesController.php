<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservas;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReservesController extends Controller
{
    public function index(): JsonResponse
    {
        $reserves = Reservas::with(['habitacion.hotel', 'usuari'])->get();
        return response()->json($reserves);
    }

    public function store(Request $request): JsonResponse
    {
        $reserva = Reservas::create($request->all());
        return response()->json($reserva, 201);
    }

    public function show($id): JsonResponse
    {
        $reserva = Reservas::with(['habitacion.hotel', 'usuari'])->findOrFail($id);
        return response()->json($reserva);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $reserva = Reservas::findOrFail($id);
        $reserva->update($request->all());
        return response()->json($reserva);
    }

    public function destroy($id): JsonResponse
    {
        Reservas::destroy($id);
        return response()->json(null, 204);
    }
}
