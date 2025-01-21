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
        $hotel = Hotel::findOrFail($id);

        $habitacionsOcupades = Reservas::countHabitacionesConfirmadas($id);
        $habitacionsLliures = Reservas::countHabitacionesLliures($id);
        $habitacionsBloquejades = Reservas::countHabitacionesBloquejades($id);
        $checkinsPendents = Reservas::countReservasPendientes($id);
        $habitacionsTotals = Reservas::getHabitacionesTotals($id);

        if ($habitacionsOcupades === 0 || $habitacionsLliures === 0) {
            $habitacionsOcupadesPercentatge = 0;
            $habitacionsLliuresPercentatge = 0;
        } else {
            $habitacionsOcupadesPercentatge = round(($habitacionsOcupades / $habitacionsTotals) * 100);
            $habitacionsLliuresPercentatge = round(($habitacionsLliures / $habitacionsTotals) * 100);
        }

        return view('hotel.home', [
            'hotel' => $hotel,
            'habitacionsOcupades' => $habitacionsOcupades,
            'habitacionsLliures' => $habitacionsLliures,
            'habitacionsBloquejades' => $habitacionsBloquejades,
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
        $estat = $request->query('estat');

        $habitacions = Habitacion::where('hotel_id', $idHotel);

        if ($estat) {
            $habitacions = $habitacions->where('estat', $estat);
        }

        $habitacions = $habitacions->paginate($paginacioHabitacions);

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

    public function checkinsPendents(Request $request)
    {
        $idHotel = $request->query('id');
        $dataEntrada = $request->query('data_entrada', Carbon::today()->format('Y-m-d'));
        $dataSortida = $request->query('data_sortida');

        // Validar que data_sortida no sea anterior a data_entrada
        if ($dataSortida && $dataSortida < $dataEntrada) {
            return redirect()->back()
                ->with('error', 'La data de sortida no pot ser anterior a la data d\'entrada.');
        }

        $reservas = Reservas::whereHas('habitacion', function ($query) use ($idHotel) {
            $query->where('hotel_id', $idHotel);
        })
            ->where('estat', 'Reservada')
            ->whereDate('data_entrada', '>=', $dataEntrada);

        if ($dataSortida) {
            $reservas->whereDate('data_sortida', '<=', $dataSortida);
        } else {
            $reservas->whereDate('data_entrada', '=', $dataEntrada);
        }

        $reservas = $reservas->with('habitacion')->orderBy('id')->get();

        return view('hotel.checkins', [
            'idHotel' => $idHotel,
            'reservas' => $reservas,
            'dataEntrada' => $dataEntrada,
            'dataSortida' => $dataSortida
        ]);
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
        $validatedData = $request->validate([
            'dni' => 'required|string|max:10',
            'nom' => 'required|string|max:50',
            'data_inici' => 'required|date',
            'data_fi' => 'required|date|after_or_equal:data_inici',
            'serveis' => 'array',
            'serveis.*' => 'exists:serveis,id',
            'comentaris' => 'nullable|string|max:255'
        ]);

        $usuari = Usuari::where('dni', $request->input('dni'))->first();
        $hotelId = Habitacion::findOrFail($habitacionId)->hotel_id;

        if (!$usuari) {
            // Si el usuario no está registrado, crear un nuevo usuario
            $usuari = Usuari::create([
                'nom' => $validatedData['nom'],
                'rol_id' => 3,
                'dni' => $validatedData['dni'],
                'hotel_id' => $hotelId
            ]);
        }

        $usuariId = $usuari->id;

        $habitacioOcupada = Reservas::where('habitacion_id', $habitacionId)
            ->where('data_entrada', '<=', $validatedData['data_fi'])
            ->where('data_sortida', '>=', $validatedData['data_inici'])
            ->exists();

        if ($habitacioOcupada) {
            return redirect()->back()
                ->with('error', 'La habitació ja està ocupada en aquestes dates');
        }

        $serveis = $validatedData['serveis'] ?? [];
       

        Reservas::create([
            'habitacion_id' => $habitacionId,
            'usuari_id' => $usuariId,
            'data_entrada' => $validatedData['data_inici'],
            'data_sortida' => $validatedData['data_fi'],
            'preu_total' => Reservas::calcularPreuTotal($serveis, $habitacionId, $validatedData['data_inici'], $validatedData['data_fi']),
            'estat' => 'reservada',
            'comentaris' => $request->input('comentaris')
        ]);
        
        $reservaId = Reservas::latest()->first()->id;

        $reservas = Reservas::findOrFail($reservaId);

        $reservas->serveis()->sync($serveis);
        

        return redirect()->route('recepcio', ['id' => $hotelId])
            ->with('success', 'Reserva completada correctament');
    }

    public function crearReserva(Request $request)
    {
        $tipusHabitacions = Habitacion::distinct()->select('tipus')->get();
        $filtros = [
            'tipus' => $request->get('tipus'),
            'status' => $request->get('status'),
            'llits' => $request->get('llits'),
            'preu' => $request->get('preu')
        ];

        $query = Habitacion::query();

        // Aplicar filtros
        if ($filtros['tipus']) {
            $query->where('tipus', $filtros['tipus']);
        }
        if ($filtros['status']) {
            $query->where('estat', $filtros['status']);
        }
        if ($filtros['llits']) {
            $filtros['llits'] = (int) $filtros['llits'];

            if ($filtros['llits'] == 5) {
                // Filtra habitaciones con capacidad >= 5
                $query->whereRaw('llits + llits_supletoris >= ?', [5]);
            } else {
                // Filtra habitaciones con capacidad exacta (resto de nums)
                $query->whereRaw('llits + llits_supletoris = ?', [$filtros['llits']]);
            }
        }
        if ($filtros['preu']) {
            $query->where('preu', '<=', $filtros['preu']);
        }

        $habitacions = $query->get();

        return view('recepcio.afegirReserva', [
            'habitacions' => $habitacions,
            'tipusHabitacions' => $tipusHabitacions,
            'filtros' => $filtros
        ]);
    }
}
