@extends('layouts.master')

@section('title', 'Recepció')

@section('content')

    <h1 class="hotel-title">{{ $hotel->nom }}</h1>
    <div class="calendar-navigation">
        <button id="prevWeek">← 7 días atrás</button>
        <button id="nextWeek">7 días adelante →</button>
    </div>
    <table id="weekCalendar">
        <thead>
            <tr id="headerRow">
                <!-- Aquí se llenarán las cabeceras -->
            </tr>
        </thead>
        <tbody>
            @foreach ($habitacions as $habitacio)
                <tr>
                    <td>{{ $habitacio->numHabitacion }}</td>
                    @php
                        $remainingDays = collect(range(0, 30))->map(function ($i) {
                            return now()->subDays(5)->addDays($i);
                        });
                    @endphp
                    @while ($remainingDays->isNotEmpty())
                        @php
                            $currentDay = $remainingDays->shift();
                            $reserva = $reservas->first(function ($r) use ($habitacio, $currentDay) {
                                return $r->habitacion_id === $habitacio->id &&
                                    $currentDay->between($r->data_entrada, $r->data_sortida->copy()->subDay());
                            });

                            if ($reserva) {
                                $colspan = 0;
                                foreach ($remainingDays as $day) {
                                    if (
                                        $day->between($reserva->data_entrada, $reserva->data_sortida->copy()->subDay())
                                    ) {
                                        $colspan++;
                                    } else {
                                        break;
                                    }
                                }
                                $colspan++;
                                $remainingDays = $remainingDays->slice($colspan - 1);
                            } else {
                                $colspan = 1;
                            }
                        @endphp

                        <td class="reservation-cell {{ $reserva ? 'reserved' : 'available' }}" colspan="{{ $colspan }}">
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

@endsection