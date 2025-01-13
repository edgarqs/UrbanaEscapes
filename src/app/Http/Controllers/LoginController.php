<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('nom', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->rol_id == 1) {
                return redirect()->intended(route('hotel.selector'));
            } elseif ($user->rol_id == 2) {
                return redirect()->intended(route('recepcio', ['id' => $user->hotel_id]));
            }
        }

        return redirect(route('login'))->withErrors([
            'nom' => 'Les credencials proporcionades no són correctes.',
            'password' => 'Les credencials proporcionades no són correctes.',
        ]);
    }

    public function logout()
    {
        session()->flush();
        Auth::logout();

        return redirect('login');
    }
}
