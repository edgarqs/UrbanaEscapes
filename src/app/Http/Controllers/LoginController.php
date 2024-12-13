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
            return redirect()->intended(route('hotel.selector'));
        }

        return redirect(route('login'))->withErrors([
            'nom' => 'Les credencials proporcionades no són correctes.',
        ]);
    }

    public function logout()
    {
        session()->flush();
        Auth::logout();

        return redirect('login');
    }
}
