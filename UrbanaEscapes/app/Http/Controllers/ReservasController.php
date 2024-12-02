<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Reservas;
use Illuminate\Http\Request;

class ReservasController extends Controller
{
    public function home(Request $request)
    {
        $id = $request->query('id');

        $habitacions = Hotel::find($id)->habitacions;

        return view('hotel.home', ['habitacions' => $habitacions]);
    }


}
