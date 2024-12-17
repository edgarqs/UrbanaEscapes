@extends('layouts.master')

@section('title', 'Recepció - {{ $hotel->nom }}')

@section('content')
    <div class="recepcio-calendar">
        <h1 class="hotel-title">{{ $hotel->nom }}</h1>
        <div class="room-calendar">
            <table class="room-table">
                <!-- Encabezados -->
                <thead>
                    <tr>
                        <th class="room-header">Habitació</th>
                        @foreach ($startDate->daysUntil($endDate) as $day)
                            <th class="day-header">{{ $day->format('d M') }}</th>
                        @endforeach
                    </tr>
                </thead>

                <!-- Habitaciones y reservas -->
                <tbody>
                    @foreach ($habitacions as $habitacio)
                        <tr>
                            <td class="room-cell">Habitació {{ $habitacio->numHabitacion }}</td>
                            @php
                                $mostrarNom = []; // Para rastrear si ya mostramos el nombre de un usuario en una reserva
                            @endphp
                            @foreach ($startDate->daysUntil($endDate) as $currentDate)
                                @php
                                    // Busca una reserva que abarque el día actual
                                    $reserva = $reservas->first(function ($r) use ($habitacio, $currentDate) {
                                        return $r->habitacion_id === $habitacio->id &&
                                               $currentDate->between($r->data_entrada, $r->data_sortida->copy()->subDay());
                                    });

                                    $mostrarNom[$reserva->id ?? null] = $mostrarNom[$reserva->id ?? null] ?? true;
                                @endphp
                                <td class="reservation-cell {{ $reserva ? 'reserved reservation-' . $reserva->id : 'available' }}">
                                    @if ($reserva && $mostrarNom[$reserva->id])
                                        <div class="reservation-details">
                                            {{ $reserva->usuari->nom }}
                                        </div>
                                        @php
                                            $mostrarNom[$reserva->id] = false; // Marca el nombre como mostrado
                                        @endphp
                                    @endif
                                </td>
                            @endforeach
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
    border: 1px solid #ddd;
    font-weight: bold;
}

/* Estados de las celdas */
.reservation-cell.available {
    background-color: #ccffcc;
    color: #006600;
}

.reservation-cell.reserved {
    color: white;
}

/* Colores dinámicos para reservas */
.reservation-1 {
    background-color: #ff9999; /* Rojo claro */
}

.reservation-2 {
    background-color: #99ccff; /* Azul claro */
}

.reservation-3 {
    background-color: #ffcc99; /* Naranja claro */
}

.reservation-4 {
    background-color: #ccff99; /* Verde claro */
}

/* Agrega más colores si tienes más reservas */

</style>