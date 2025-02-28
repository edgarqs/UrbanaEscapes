<?php

namespace App\Http\Controllers\ApiV2;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use App\Models\Hotel;
use Illuminate\Http\Request;

class NoticiesApiController extends Controller
{
    // Muestra todas las noticias publicadas
    public function index(Request $request)
    {
        $limit = $request->query('limit', null);

        $query = Noticia::where('publicada', 1)
            ->with('fotos')
            ->orderBy('created_at', 'desc');

        if ($limit) {
            $noticies = $query->take(3)->get(['id', 'titol', 'descripcio_curta', 'descripcio_llarga']);
        } else {
            $noticies = $query->get(['id', 'titol', 'descripcio_curta', 'descripcio_llarga']);
        }

        return response()->json($noticies);
    }

    // Muestra las noticias publicadas relacionadas con el hotel especificado
    public function show($hotel)
    {
        $hotelModel = Hotel::where('id', $hotel)
            ->orWhere('codi_hotel', $hotel)
            ->first();

        if (!$hotelModel) {
            return response()->json(['error' => 'Hotel no encontrado'], 404);
        }

        $noticies = $hotelModel->noticies()
            ->where('publicada', 1)
            ->with('fotos')
            ->orderBy('created_at', 'desc')
            ->get(['id', 'titol', 'descripcio_curta', 'descripcio_llarga']);

        return response()->json($noticies);
    }

    // Muestra las últimas 3 noticias publicadas relacionadas con el hotel especificado
    public function latest($hotel)
    {
        $hotelModel = Hotel::where('id', $hotel)
            ->orWhere('codi_hotel', $hotel)
            ->first();

        if (!$hotelModel) {
            return response()->json(['error' => 'Hotel no encontrado'], 404);
        }

        $noticies = $hotelModel->noticies()
            ->where('publicada', 1)
            ->with('fotos')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get(['id', 'titol', 'descripcio_curta', 'descripcio_llarga']);

        return response()->json($noticies);
    }
}
