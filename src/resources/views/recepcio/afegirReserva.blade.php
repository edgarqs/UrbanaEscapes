@extends('layouts.master')

@section('title', 'Afegir Reserva')

@section('content')
    <h1>Afegir Reserva</h1>

    <div class="filtros">
        <form method="GET" action="{{ route('recepcio.afegirReserva') }}">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="tipus">Tipus d'habitació</label>
                    <select name="tipus" id="tipus" class="form-control">
                        <option value="">Mostrar tot</option>
                        @foreach ($tipusHabitacions as $tipusHabitacio)
                            <option value="{{ $tipusHabitacio->tipus }}"
                                {{ request('tipus') == $tipusHabitacio->tipus ? 'selected' : '' }}>
                                {{ $tipusHabitacio->tipus }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Estat d'habitació</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Mostrar tot</option>
                        <option value="ocupada" {{ request('status') == 'ocupada' ? 'selected' : '' }}>Ocupada</option>
                        <option value="lliure" {{ request('status') == 'lliure' ? 'selected' : '' }}>Lliure</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="llits">Capacitat</label>
                    <select name="llits" id="llits" class="form-control">
                        <option value="">Mostrar tot</option>
                        @foreach ([1, 2, 3, 4, '+5'] as $option)
                            <option value="{{ $option }}" {{ request('llits') == $option ? 'selected' : '' }}>
                                {{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="preu">Preu</label>
                    <div>
                        <input type="range" id="preu" name="preu" min="50" max="200"
                            value="{{ request('preu', 200) }}" oninput="updateValue(this.value)">
                        <span id="preu-value">{{ request('preu', 200) }} €</span>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="button">Filtrar</button>
                </div>
            </div>
        </form>
    </div>

    <div class="cards cards--habitacions">
        @foreach ($habitacions as $habitacio)
            <a class="card">
                <h2 class="card__header">Habitació: {{ $habitacio->numHabitacion }}</h2>
                <div class="card__body">
                    <p>{{ $habitacio->tipus }}</p>
                    <p>Estat: {{ $habitacio->getEstat() }}</p>
                    <p>Preu: {{ $habitacio->preu }}€</p>
                    <p>Capacitat: {{ $habitacio->llits + $habitacio->llits_supletoris }}</p>
                    <button class="button button--primary"
                        onclick="window.location.href='{{ route('reserves.index', $habitacio->id) }}'">Afegir
                        reserva</button>
                </div>
            </a>
        @endforeach
    </div>
@endsection
