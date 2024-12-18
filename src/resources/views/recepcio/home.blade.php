@extends('layouts.master')

@section('title', 'Recepció')

@section('content')
    @php
        \Carbon\Carbon::setLocale('ca');
        $today = \Carbon\Carbon::today();
        $startDate = $today->copy()->subDays(5);
        $endDate = $today->copy()->addDays(26);
        $days = $startDate->daysUntil($endDate)->toArray(); // Array de fechas
    @endphp
    <div class="recepcio-calendar">
        <h1 class="hotel-title">{{ $hotel->nom }}</h1>
        <div class="room-calendar">
            <table class="room-table">
                <!-- Encabezados -->
                <thead>
                    <tr>
                        <th></th>
                        @foreach ($days as $day)
                            <th class="day-header">{{ $day->translatedFormat('D j') }}</th>
                        @endforeach
                    </tr>
                </thead>

                <!-- Habitaciones y reservas -->
                <tbody>
                    @foreach ($habitacions as $habitacio)
                        <tr>
                            <td class="room-cell">{{ $habitacio->numHabitacion }}</td>
                            @php
                                $remainingDays = $days; // Copia de días para procesar
                            @endphp
                            @while (!empty($remainingDays))
                                @php
                                    $currentDay = array_shift($remainingDays);
                                    $reserva = $reservas->first(function ($r) use ($habitacio, $currentDay) {
                                        return $r->habitacion_id === $habitacio->id &&
                                            $currentDay->between($r->data_entrada, $r->data_sortida->copy()->subDay());
                                    });

                                    if ($reserva) {
                                        $colspan = 0;
                                        foreach ($remainingDays as $day) {
                                            if ($day->between($reserva->data_entrada, $reserva->data_sortida->copy()->subDay())) {
                                                $colspan++;
                                            } else {
                                                break;
                                            }
                                        }
                                        $colspan++;
                                        $remainingDays = array_slice($remainingDays, $colspan - 1);
                                    } else {
                                        $colspan = 1;
                                    }
                                @endphp

                                <td class="reservation-cell {{ $reserva ? 'reserved' : 'available' }}"
                                    colspan="{{ $colspan }}">
                                    @if ($reserva)
                                        <div class="reservation-details">
                                            <p>{{ $reserva->usuari->nom }}</p>
                                        </div>
                                    @endif
                                </td>
                            @endwhile
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<style>

    /* Estilo base */
    .reservation-cell {
        text-align: center;
        padding: 8px;
        font-weight: bold;
        width: 100px;
        height: 50px;
        box-sizing: border-box;
    }

    .reservation-cell.available {
        background-color: #ccffcc;
        border: 1px solid #ddd;
    }

    .reservation-cell.reserved {
        background-color: #ffcccc;
        border: 1px solid #ddd;
    }
</style>
