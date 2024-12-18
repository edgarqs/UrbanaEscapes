@extends('layouts.master')

@section('title', 'Llistat de Check-Ins')

@section('content')

<h1>Llistat de Check-Ins Pendents</h1>

<form method="GET" action="{{ route('reservas.checkins') }}">
    <div class="form-row">
        <div class="form-group">
            <label for="start_date">Data Inici</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div class="form-group">
            <label for="end_date">Data Fi</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
        <div class="form-group">
            <button type="submit" class="button">Filtrar</button>
        </div>
    </div>
</form>

<div class="cards">
    @foreach ($reservas as $reserva)
        <div class="card">
            <h2 class="card__header">Reserva ID: {{ $reserva->id }}</h2>
            <div class="card__body">
                <p>Nom del client: {{ $reserva->usuari->nom }}</p>
                <p>Duració de l'estada: {{ $reserva->data_entrada }} - {{ $reserva->data_sortida }}</p>
                <p>Tipus d'habitació: {{ $reserva->habitacion->tipus }}</p>
                <p>Ocupants de l'habitació: {{ $reserva->habitacion->llits }}</p>
                <p>Habitació assignada: {{ $reserva->habitacion->numHabitacion }}</p>
                <p>Estat de la reserva: {{ $reserva->estat }}</p>
                <p>Preu de la reserva: {{ $reserva->preu_total }}€</p>
                <p>Notes: {{ $reserva->comentaris }}</p>
            </div>
        </div>
    @endforeach
</div>

@endsection     