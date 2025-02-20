<?php

namespace App\Http\Controllers\ApiV2;

use App\Http\Controllers\Controller;
use App\Models\ReservaToken;
use App\Models\Feedbacks;
use App\Models\FotosFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

        /*$feedback = Feedbacks::create([
            'reserva_id' => $reserva_id,
            'estrelles' => $request->estrelles,
            'comentari' => $request->comentari,
        ]);*/

        // Elimina el token
        ReservaToken::where('token', $request->token)->delete();

        return response()->json(['message' => 'Feedback enviado correctamente'], 200);
    }
}
