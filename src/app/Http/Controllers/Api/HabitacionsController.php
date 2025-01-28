<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Habitacion;
use Illuminate\Http\JsonResponse;

class HabitacionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $habitacions = Habitacion::all();
        return response()->json($habitacions);
    }

    public function store(Request $request): JsonResponse
    {
        $hotel = Habitacion::create($request->all());
        return response()->json($hotel, 201);
    }

    public function show($id): JsonResponse
    {
        $hotel = Habitacion::findOrFail($id);
        return response()->json($hotel);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $hotel = Habitacion::findOrFail($id);
        $hotel->update($request->all());
        return response()->json($hotel);
    }

    public function destroy($id): JsonResponse
    {
        Habitacion::destroy($id);
        return response()->json(null, 204);
    }
}
