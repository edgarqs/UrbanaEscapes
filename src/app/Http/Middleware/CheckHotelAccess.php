<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckHotelAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();

        if ($user->rol_id == 2) {
            $hotelId = $request->query('id');

            if ($user->hotel_id != $hotelId) {
                return redirect()->route('recepcio',['id' => $user->hotel_id] )->withErrors('No tens permisos per accedir a aquesta pàgina');
            }
        }
        
        return $next($request);
    }
}
