@extends('layouts.master')

@section('title', 'Recepció')

@section('content')
    @if (session('error'))
        <div class="message-content message-content--error" id="status-message">
            {{ session('error') }}
        </div>
    @endif

    <div class="form form--todaLaPagina card">
        <h3 class="center">Afegir reserva</h3>
        <form>
            @csrf

            <h4>Dades del client</h4>
            <div class="form-row d-flex">
                <div class="form-group flex-fill mr-3">
                    <label for="dni">DNI</label>
                    <input type="text" name="dni" id="dni" class="form-control @error('dni') is-invalid @enderror"
                        value="{{ old('dni') }}" maxlength="50" required>
                    @error('dni')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group flex-fill">
                    <label for="nom">Nom y cognoms</label>
                    <input type="text" name="nom" id="nom"
                        class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" maxlength="23"
                        required>
                    @error('nom')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group flex-fill">
                    <label for="email">Correu electrònic</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" maxlength="50"
                        required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="contenedor-doble">
                <div class="subcontenedor-flex">
                    <h4>Dades de l'habitació</h4>
                    <div class="form-row d-flex">
                        <div class="form-group flex-fill mr-3">
                            <label for="numHabitacio">Nº Habitació</label>
                            <input type="text" name="numHabitacio" id="numHabitacio"
                                value="{{ $habitacio->numHabitacion }}" required disabled>
                            @error('numHabitacio')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group flex-fill">
                            <label for="tipusHabitacio">Tipus</label>
                            <input type="text" name="tipusHabitacio" id="tipusHabitacio" value="{{ $habitacio->tipus }}"
                                required disabled>
                            @error('tipusHabitacio')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group flex-fill">
                            <label for="preuHabitacio">Preu base</label>
                            <input type="text" name="preuHabitacio" id="preuHabitacio" value="{{ $habitacio->preu }} €"
                                required disabled>
                            @error('preuHabitacio')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row d-flex">
                        <div class="form-group flex-fill">
                            <label for="llits">Llits</label>
                            <input type="text" name="llits" id="llits" value="{{ $habitacio->llits }}" required
                                disabled>
                            @error('llits')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group flex-fill">
                            <label for="llitsSupletoris">Llits Supletoris</label>
                            <input type="text" name="llitsSupletoris" id="llitsSupletoris"
                                value="{{ $habitacio->llits_supletoris }}" required disabled>
                            @error('llitsSupletoris')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="subcontenedor-flex">
                    <h4>Serveis adicionals</h4>
                    <ul class="list-group">
                        @foreach ($serveis as $servei)
                            <li class="form-check-label" for="servei{{ $servei->id }}">
                                {{ $servei->nom }}: {{ $servei->preu }}€
                                <input class="form-check-input" type="checkbox" value="{{ $servei->id }}"
                                    id="servei{{ $servei->id }}" name="serveis[]">
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="contenedor-doble">
                <div class="subcontenedor-flex">
                    <h4>Dades de la reserva</h4>
                    <div class="form-row d-flex">
                        <div class="form-group flex-fill">
                            <label for="dataIniciReserva">Data Inici</label>
                            <input type="date" name="dataIniciReserva" id="dataIniciReserva" value="{{ $diaActual }}"
                                required>
                            @error('dataIniciReserva')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group flex-fill">
                            <label for="dataFiReserva">Data Fi</label>
                            <input type="date" name="dataFiReserva" id="dataFiReserva" value="{{ $diaSeguent }}"
                                required>
                            @error('dataFiReserva')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group flex-fill">
                        <label for="comentaris">Comentaris</label>
                        <input type="text" name="comentaris" id="comentaris"
                            class="form-control @error('comentaris') is-invalid @enderror"
                            value="{{ old('comentaris') }}" required>
                        @error('comentaris')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="button button--primary button--margin-top">Registrar reserva</button>
        </form>
    </div>

@endsection
