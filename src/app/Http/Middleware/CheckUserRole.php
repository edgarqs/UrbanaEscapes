<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check() || Auth::user()->rol_id != 1) {
            // Redirigir a una página de error o a la página de inicio
            return redirect('/login')->withErrors('No tienes permiso para acceder a esta página.');
        }

        return $next($request);
    }
}