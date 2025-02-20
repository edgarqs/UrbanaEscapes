<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuari;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsuariController extends Controller
{
    public function index(): JsonResponse
    {
        $usuaris = Usuari::all();
        return response()->json($usuaris);
    }

    public function store(Request $request): JsonResponse
    {
        $usuari = Usuari::create($request->all());
        return response()->json($usuari, 201);
    }

    public function show($identifier): JsonResponse
    {
        $usuari = Usuari::where('id', $identifier)->orWhere('email', $identifier)->firstOrFail();
        return response()->json($usuari);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $usuari = Usuari::findOrFail($id);
        $usuari->update($request->all());
        return response()->json($usuari);
    }

    public function destroy($id): JsonResponse
    {
        Usuari::destroy($id);
        return response()->json(null, 204);
    }
}
