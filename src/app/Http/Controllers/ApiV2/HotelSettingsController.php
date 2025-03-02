<?php

namespace App\Http\Controllers\ApiV2;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelSetting;
use Illuminate\Http\Request;

class HotelSettingsController extends Controller
{
    public function show($hotelId)
    {
        // Buscar el hotel por ID o token
        $hotel = Hotel::where('id', $hotelId)->orWhere('codi_hotel', $hotelId)->firstOrFail();

        // Obtener la configuración del hotel
        $settings = HotelSetting::where('hotel_id', $hotel->id)->firstOrFail();

        return response()->json([
            'secciones_visibles' => $settings->secciones_visibles,
            'secciones_orden' => $settings->secciones_orden,
            'noticias_cantidad' => $settings->noticias_cantidad,
            'feedbacks_cantidad' => $settings->feedbacks_cantidad,
        ]);
    }

    public function edit($hotelId)
    {
        $settings = HotelSetting::where('hotel_id', $hotelId)->firstOrFail();
        return view('hotel.configHotel', compact('settings'));
    }

    public function update(Request $request, $hotelId)
    {
        $settings = HotelSetting::where('hotel_id', $hotelId)->firstOrFail();

        $settings->update([
            'secciones_visibles' => $request->input('secciones_visibles'),
            'secciones_orden' => $request->input('secciones_orden'),
            'noticias_cantidad' => $request->input('noticias_cantidad'),
            'feedbacks_cantidad' => $request->input('feedbacks_cantidad'),
        ]);

        return redirect()->route('hotel.configHotel', ['id' => $hotelId])
            ->with('status', 'Configuración actualizada correctamente');
    }
}
