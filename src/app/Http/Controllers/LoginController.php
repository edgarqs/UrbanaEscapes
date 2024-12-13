<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
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

        session()->flash('status', 'Incorrect username or password!');

        return redirect(route('login'));
    }

    public function logout()
    {
        session()->flush();
        Auth::logout();

        return redirect('login');
    }
}
