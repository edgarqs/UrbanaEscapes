<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HotelController extends Controller
{
    public function index(): JsonResponse
    {
        $hotels = Hotel::all();
        return response()->json($hotels);
    }

    public function store(Request $request): JsonResponse
    {
        $hotel = Hotel::create($request->all());
        return response()->json($hotel, 201);
    }

    public function show($id): JsonResponse
    {
        $hotel = Hotel::findOrFail($id);
        return response()->json($hotel);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->update($request->all());
        return response()->json($hotel);
    }

    public function destroy($id): JsonResponse
    {
        Hotel::destroy($id);
        return response()->json(null, 204);
    }
}
