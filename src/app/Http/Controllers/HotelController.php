<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Database\Seeders\NoticiaSeeder;
use Database\Seeders\DatabaseSeeder;

class HotelController extends Controller
{

    public function index()
    {
        $hotels = Hotel::all();
        return view('hotel.selector', ['hotels' => $hotels]);
    }
    public function create()
    {
        return view('hotel.create');
    }
    public function guardarHotel(Request $request)
    {
        $dades = $request->validate([
            'nom' => 'required|string|max:30',
            'adreca' => 'required|string|max:40',
            'ciutat' => 'required|string|max:50',
            'pais' => 'required|string|max:23',
            'email' => 'required|email|max:50',
            'telefon' => 'required|string|max:15',
            'clients' => 'required|integer|min:0',
            'habitacions' => 'required|integer|min:0',
            'reserves' => 'required|integer|min:0',
            'feedbacks' => 'required|integer|min:0',
            'noticies' => 'required|integer|min:0',
        ]);

        // Verificar si el email ya existe en la base de datos
        if (Hotel::where('email', $dades['email'])->exists()) {
            return redirect()->back()->withErrors(['email' => 'L\'email ja existeix.'])->withInput();
        }

        // Crear el hotel
        $hotel = Hotel::create([
            'nom' => $dades['nom'],
            'adreca' => $dades['adreca'],
            'ciutat' => $dades['ciutat'],
            'pais' => $dades['pais'],
            'email' => $dades['email'],
            'telefon' => $dades['telefon'],
        ]);

        $numClients = $dades['clients'];
        $numHabitacions = $dades['habitacions'];
        $numReserves = $dades['reserves'];
        $numFeedbacks = $dades['feedbacks'];
        $numNoticies = $dades['noticies'];

        $seeder = new DatabaseSeeder();
        $seeder->CreateHotelSedder($hotel->id, $numClients, $numHabitacions, $numReserves, $numFeedbacks);

        // Ejecutar el seeder de noticias con el número indicado
        $noticiaSeeder = new NoticiaSeeder();
        $noticiaSeeder->createNoticiasForHotel($hotel->id, $numNoticies);

        return redirect()->route('hotel.home', ['id' => $hotel->id])
            ->with('status', 'Hotel creat correctament i dades del hotel creades correctament');
    }


    // Formulario de creación de datos del hotel
    public function formHotelDetalls()
    {
        $hotelNom = session('hotel_nom');
        $hotelId = session('hotel_id');
        return view('hotel.crearDetalls', ['hotelNom' => $hotelNom, 'hotelId' => $hotelId]);
    }
}
