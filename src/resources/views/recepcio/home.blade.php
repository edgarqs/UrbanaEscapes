@extends('layouts.master')

@section('title', 'Recepció')

@section('content')
    @if (session('success'))
        <div class="message-content message-content--success" id="status-message">
            {{ session('success') }}
        </div>
    @endif
    <meta hidden name="hotel-id" content="{{ $hotel->id }}">
    <h1 class="hotel-title">{{ $hotel->nom }}</h1>
    <div class="calendar-navigation">
        <button class="button-calendar" id="prevWeek">← 7 dias enrere</button>
        <button class="button-reserva" onclick="window.location='{{ route('recepcio.afegirReserva') }}'">Afegir reserva</button>
        <button class="button-calendar" id="nextWeek">7 dias endavant →</button>
    </div>
    <table id="weekCalendar">
        <thead>
            <tr id="headerRow">
                <!-- Aquí se llenarán las cabeceras -->
            </tr>
        </thead>
        <tbody id="calendarBody">
            <!-- Aquí se llenarán las filas del calendario -->
            @foreach ($reserves as $reserva)
                <div id="popup-{{ $reserva->id }}" class="popup" style="display: none;">
                    <dialog>
                        <div>
                            <h2>Detall de la reserva</h2>
                            <p>Número d'Habitació: {{ $reserva->habitacion->numHabitacion }}</p>
                            <p>Tipus: {{ $reserva->habitacion->tipo }}</p>
                            <p>Estat: {{ $reserva->habitacion->estat }}</p>

                            <h3>Detall del Client</h3>
                            <p>Nom: {{ $reserva->usuari->nom }}</p>
                            <p>Email: {{ $reserva->usuari->email }}</p>

                            <h3>Detall d'Estada</h3>
                            <p>Data d'Entrada: {{ $reserva->data_entrada->format('d-m-Y') }}</p>
                            <p>Data de Sortida: {{ $reserva->data_sortida->format('d-m-Y') }}</p>

                            <h3>Detall de Facturació</h3>
                            <p>Preu Total: {{ $reserva->preu_total }} €</p>
                            <p>Comentaris: {{ $reserva->comentaris }}</p>

                            <h3>Detalls de Pagament</h3>
                            <p>Estat de Pagament: {{ $reserva->estat }}</p>

                        </div>
                    </dialog>

                </div>
            @endforeach
        </tbody>
    </table>
    <script src="{{ asset('js/calendar.js') }}"></script>
@endsection
