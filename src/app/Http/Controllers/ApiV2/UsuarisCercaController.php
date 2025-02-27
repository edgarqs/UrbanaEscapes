<?php

namespace App\Http\Controllers\ApiV2;

use App\Models\Usuari;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class UsuarisCercaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Usuari::query();

        if ($request->has('hotel_id')) {
            $query->where('hotel_id', $request->input('hotel_id'));
        }

        if ($request->has('rol_id')) {
            $query->where('rol_id', $request->input('rol_id'));
        }

        $usuaris = $query->get();
        return response()->json($usuaris);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $email = $request->input('email');
        $usuari = Usuari::where('email', $email)->first();

        if ($usuari) {
            return response()->json($usuari, 200);
        }

        $usuari = Usuari::create($request->all());
        return response()->json($usuari, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $usuari = Usuari::where('id', $id)
            ->orWhere('hotel_id', $id)
            ->orWhere('rol_id', $id)
            ->firstOrFail();
        return response()->json($usuari);
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
