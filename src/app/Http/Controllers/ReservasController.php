<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Usuari;
use App\Models\Serveis;
use App\Models\Reservas;
use App\Models\Habitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ReservasController extends Controller
{
    public function home(Request $request)
    {
        $id = $request->query('id');
        $hotel = Hotel::findOrFail($id); //? Busca el hotel amb l'id que li passem per paràmetre

        $habitacionsOcupades = Reservas::countHabitacionesConfirmadas($id);
        $habitacionsLliures = Reservas::countHabitacionesLliures($id);
        $checkinsPendents = Reservas::countReservasPendientes($id);
        $habitacionsTotals = Reservas::getHabitacionesTotals($id);

        $habitacionsOcupadesPercentatge = round(($habitacionsOcupades / $habitacionsTotals) * 100);
        $habitacionsLliuresPercentatge = round(($habitacionsLliures / $habitacionsTotals) * 100);

        return view('hotel.home', [
            'hotel' => $hotel,
            'habitacionsOcupades' => $habitacionsOcupades,
            'habitacionsLliures' => $habitacionsLliures,
            'checkinsPendents' => $checkinsPendents,
            'habitacionsTotals' => $habitacionsTotals,
            'habitacionsOcupadesPercentatge' => $habitacionsOcupadesPercentatge,
            'habitacionsLliuresPercentatge' => $habitacionsLliuresPercentatge,
        ]);
    }

    public function habitacions(Request $request)
    {
        $paginacioHabitacions = env('PAGINACIO_HABITACIONS', 100);
        $idHotel = $request->query('id');
        $habitacions = Habitacion::where('hotel_id', $idHotel)->paginate($paginacioHabitacions);

        return view('hotel.habitacions', ['idHotel' => $idHotel, 'habitacions' => $habitacions]);
    }

    public function checkin($id)
    {
        $habitacio = Habitacion::findOrFail($id);
        $reserva = $habitacio->reservas()->where('estat', 'reservada')->first();

        if ($reserva) {
            $reserva->estat = 'Checkin';
            $reserva->save();

            $habitacio->estat = 'Ocupada';
            $habitacio->save();
        }

        return redirect()->back()
            ->with('success', 'Check-In completat correctament per a l\'habitació número ' . $habitacio->numHabitacion);
    }


    public function checkout($id)
    {
        $habitacio = Habitacion::findOrFail($id);
        $reserva = $habitacio->reservas()->where('estat', 'checkin')->first();

        if ($reserva) {
            $reserva->estat = 'Checkout';
            $reserva->save();

            $habitacio->estat = 'Bloquejada';
            $habitacio->save();
        }

        return redirect()->back()
            ->with('success', 'Check-Out completat correctament per a l\'habitació número ' . $habitacio->numHabitacion);
    }

    public function bloquejar($id)
    {
        $habitacio = Habitacion::findOrFail($id);

        if ($habitacio->estat === 'Lliure') {
            $habitacio->estat = 'Bloquejada';
            $habitacio->save();
        }

        return redirect()->back()
            ->with('success', 'Habitació Nº ' . $habitacio->numHabitacion . ' posada en manteniment.');
    }

    public function desbloquejar($id)
    {
        $habitacio = Habitacion::findOrFail($id);

        if ($habitacio->estat === 'Bloquejada') {
            $habitacio->estat = 'Lliure';
            $habitacio->save();
        }

        return redirect()->back()
            ->with('success', 'Habitació Nº ' . $habitacio->numHabitacion . ' desbloquejada.');
    }

    public function checkins(Request $request)
    {
        $filters = [
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date'),
            'status' => $request->get('status'),
            'search' => $request->get('search'),
        ];

        $reservas = Reservas::getCheckinsFiltrats($filters);

        return view('hotel.checkins', compact('reservas'));
    }

    public function index($habitacionId)
    {
        $usuaris = Usuari::all();
        $habitacio = Habitacion::findOrFail($habitacionId);
        $serveis = Serveis::all();
        $diaActual = Carbon::now()->format('Y-m-d');
        $diaSeguent = Carbon::now()->addDays(1)->format('Y-m-d');
        $preuPerDies = Reservas::calcularPreuPerDies($habitacio, $diaActual, $diaSeguent);

        return view('recepcio.reservas', [
            'habitacionId' => $habitacionId,
            'usuaris' => $usuaris,
            'habitacio' => $habitacio,
            'serveis' => $serveis,
            'diaActual' => $diaActual,
            'diaSeguent' => $diaSeguent,
            'preuPerDies' => $preuPerDies
        ]);
    }


    public function store(Request $request, $habitacionId)
    {
        $usuari = Usuari::where('dni', $request->input('dni'))->first();
        $hotelId = Habitacion::findOrFail($habitacionId)->hotel_id;

        if (!$usuari) {
            // Si el usuario no está registrado, crear un nuevo usuario
            $usuari = Usuari::create([
                'nom' => $request->input('nom'),
                'email' => $request->input('email'),
                'rol_id' => 3,
                'dni' => $request->input('dni'),
                'hotel_id' => $hotelId
            ]);
        }

        $usuariId = $usuari->id;
        $validatedData = $request->validate([
            'data_inici' => 'required|date',
            'data_fi' => 'required|date|after_or_equal:data_inici',
            'serveis' => 'array',
            'serveis.*' => 'exists:serveis,id',
        ]);

        $habitacioOcupada = Reservas::where('habitacion_id', $habitacionId)
            ->where('data_entrada', '<=', $validatedData['data_fi'])
            ->where('data_sortida', '>=', $validatedData['data_inici'])
            ->exists();

        if ($habitacioOcupada) {
            return redirect()->back()
                ->with('error', 'La habitació ja està ocupada en aquestes dates');
        }

        $habitacio = Habitacion::findOrFail($habitacionId);
        $serveis = $validatedData['serveis'] ?? [];
        $habitacio->serveis()->sync($serveis);

        Reservas::create([
            'habitacion_id' => $habitacionId,
            'usuari_id' => $usuariId,
            'data_entrada' => $validatedData['data_inici'],
            'data_sortida' => $validatedData['data_fi'],
            'preu_total' => Reservas::calcularPreuTotal($serveis, $habitacio, $validatedData['data_inici'], $validatedData['data_fi']),
            'estat' => 'reservada',
            'comentaris' => $request->input('comentaris')
        ]);

        return redirect()->route('recepcio', ['id' => $hotelId])
            ->with('success', 'Reserva completada correctament');
    }

    public function crearReserva()
    {
        $habitacions = Habitacion::all();
        $usuaris = Usuari::all();
        $serveis = Serveis::all();
        $tipusHabitacions = Habitacion::getTipusHabitacions();
        
        return view('recepcio.afegirReserva', [
            'habitacions' => $habitacions,
            'usuaris' => $usuaris,
            'serveis' => $serveis,
            'tipusHabitacions' => $tipusHabitacions
        ]);
    }
}
