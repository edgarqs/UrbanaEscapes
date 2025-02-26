<?php

namespace App\Http\Controllers\ApiV2;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use App\Models\Hotel;
use Illuminate\Http\Request;

class NoticiesApiController extends Controller
{

    // MOstra totes les noticies publicades
    public function index()
    {
        $noticies = Noticia::where('publicada', 1)
            ->with('fotos:id,noticia_id,foto')
            ->orderBy('created_at', 'desc')
            ->get(['id', 'titol', 'descripcio_curta', 'descripcio_llarga']);

        return response()->json($noticies);
    }

    // Mostra les noticies publicades relacionades amb l'hotel especificat
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
            ->get(['id', 'titol', 'descripcio_curta', 'descripcio_llarga']);

        return response()->json($noticies);
    }
}
