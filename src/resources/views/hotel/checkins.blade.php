@extends('layouts.master')

@section('title', 'Check-Ins')

@section('content')

    @if (session('error'))
        <div class="message-content message-content--error" id="status-message">
            {{ session('error') }}
        </div>
    @endif

    <h1>Llistat de Check-Ins Pendents</h1>

    <div class="filtros-reservas">
        <form method="GET" action="{{ route('reservas.checkins') }}">
            @csrf
            <input type="hidden" name="id" value="{{ $idHotel }}">
            <div class="form-row">
                <div class="form-group">
                    <label for="data_entrada">Data Entrada</label>
                    <input type="date" name="data_entrada" id="data_entrada" class="form-control"
                        value="{{ $dataEntrada }}">
                </div>
                <div class="form-group">
                    <label for="data_sortida">Data Sortida</label>
                    <input type="date" name="data_sortida" id="data_sortida" class="form-control"
                        value="{{ $dataSortida }}">
                </div>
                <div class="form-group">
                    <button type="submit" class="button">Filtrar</button>
                </div>
            </div>
        </form>
    </div>

    <div>
        <table class="tabla-reservas">
            <thead>
                <tr>
                    <th>Reserva Nº</th>
                    <th>Client</th>
                    <th>Duració</th>
                    <th>Tipus Habitació</th>
                    <th>Nº Habitació</th>
                    <th>Estat Reserva</th>
                    <th>Preu Total</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservas as $reserva)
                    <tr>
                        <td>
                            <p>{{ $reserva->id }}</p>
                        </td>
                        <td>
                            <p>{{ $reserva->usuari->nom }}</p>
                        </td>
                        <td>
                            <p>{{ $reserva->data_entrada->diffInDays($reserva->data_sortida) }} dies</p>
                        </td>
                        <td>
                            <p>{{ $reserva->habitacion->tipus }}</p>
                        </td>
                        <td>
                            <p>{{ $reserva->habitacion ? $reserva->habitacion->numHabitacion : 'No assignada' }}</p>
                        </td>
                        <td>
                            <p class="status status-{{ strtolower($reserva->estat) }}">{{ $reserva->estat }}</p>
                        </td>
                        <td>
                            <p>{{ $reserva->preu_total }} €</p>
                        </td>
                        <td>
                            <p>{{ $reserva->comentaris }}</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
