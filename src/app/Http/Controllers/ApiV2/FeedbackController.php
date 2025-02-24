<?php

namespace App\Http\Controllers\ApiV2;

use App\Models\Hotel;
use App\Models\Feedbacks;
use App\Models\ReservaToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{

    //* Verifica que el token exista en la db
    public function verificarToken($token)
    {
        $reservaToken = ReservaToken::where('token', $token)->first();

        if ($reservaToken) {
            return response()->json([
                'id_reserva' => $reservaToken->reserva_id,
            ]);
        }

        return response()->json([], 404); //? Si no existe el token retorna 404
    }


    public function enviarFeedback(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'estrelles' => 'required|integer',
            'comentari' => 'required|string',
        ]);

        $reservaToken = ReservaToken::where('token', $request->token)->first();

        if (!$reservaToken) {
            return response()->json(['message' => 'Token no válido'], 400);
        }

        // Para saber el id de la reserva a trves del token
        $reserva_id = $reservaToken->reserva_id;

        $feedback = Feedbacks::create([
            'reserva_id' => $reserva_id,
            'estrelles' => $request->estrelles,
            'comentari' => $request->comentari,
        ]);

        // Elimina el token
        ReservaToken::where('token', $request->token)->delete();

        return response()->json(['message' => 'Feedback enviado correctamente'], 200);
    }

    //? Retorna els feedbacks d'un hotel
    public function getFeedbacksByHotel($hotelId)
    {
        // Buscar el hotel por id o codi_hotel
        $hotel = Hotel::where('id', $hotelId)->orWhere('codi_hotel', $hotelId)->first();

        if (!$hotel) {
            return response()->json(['message' => 'Hotel no encontrado'], 404);
        }

        // Obtener todas las habitaciones del hotel
        $habitacions = $hotel->habitacions()->pluck('id');

        $reservas = \App\Models\Reservas::whereIn('habitacion_id', $habitacions)->pluck('id');

        $feedbacks = Feedbacks::whereIn('reserva_id', $reservas)->get();

        return response()->json($feedbacks);
    }
}
