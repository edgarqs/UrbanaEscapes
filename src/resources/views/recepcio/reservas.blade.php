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
        <form action="{{ route('reserves.store', ['habitacionId' => $habitacio->id]) }}" method="post">
            @csrf

            <h4>Dades del client</h4>
            <div class="form-row d-flex">
                <div class="form-group flex-fill mr-3">
                    <label for="dni">Document d'identitat <i>(DNI/NIE/NIF)</i></label>
                    <input type="text" name="dni" id="dni"
                        class="form-control @error('dni') is-invalid @enderror" value="{{ old('dni') }}" maxlength="10"
                        required>
                    @error('dni')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group flex-fill">
                    <label for="nom">Nom y cognoms</label>
                    <input type="text" name="nom" id="nom"
                        class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" maxlength="50"
                        required>
                    @error('nom')
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
                            <input type="text" class="disabledInformacio" name="numHabitacio" id="numHabitacio"
                                value="{{ $habitacio->numHabitacion }}" required disabled>
                            @error('numHabitacio')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group flex-fill">
                            <label for="tipusHabitacio">Tipus</label>
                            <input type="text" class="disabledInformacio" name="tipusHabitacio" id="tipusHabitacio"
                                value="{{ $habitacio->tipus }}" required disabled>
                            @error('tipusHabitacio')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group flex-fill">
                            <label for="preuHabitacio">Preu base</label>
                            <input type="text" class="disabledInformacio" name="preuHabitacio" id="preuHabitacio"
                                value="{{ $habitacio->preu }} €" required disabled>
                            @error('preuHabitacio')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row d-flex">
                        <div class="form-group flex-fill">
                            <label for="llits">Llits</label>
                            <input type="text" class="disabledInformacio" name="llits" id="llits"
                                value="{{ $habitacio->llits }}" required disabled>
                            @error('llits')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group flex-fill">
                            <label for="llitsSupletoris">Llits Supletoris</label>
                            <input type="text" class="disabledInformacio" name="llitsSupletoris" id="llitsSupletoris"
                                value="{{ $habitacio->llits_supletoris }}" required disabled>
                            @error('llitsSupletoris')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="subcontenedor-flex">
                    <h4>Serveis adicionals</h4>
                    <div class="checkbox-contenedor">
                        <div class="checkbox">
                            <ul>
                                @foreach ($serveis as $servei)
                                    <li>
                                        <input type="checkbox" name="serveis[]" id="servei{{ $servei->id }}" value="{{ $servei->id }}"
                                            {{ in_array($servei->id, old('serveis', [])) ? 'checked' : '' }}>
                                        <label for="servei{{ $servei->id }}">{{ $servei->nom }} <span class="text-cursiva">(+{{ $servei->preu }} €)</span></label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contenedor-doble">
                <div class="subcontenedor-flex">
                    <h4>Dades de la reserva</h4>
                    <div class="form-row d-flex">
                        <div class="form-group flex-fill">
                            <label for="data_inici">Data Inici</label>
                            <input type="date" name="data_inici" id="data_inici" class="@error('data_inici') is-invalid @enderror" value="{{ old('data_inici') ?? $diaActual }}"
                                required>
                            @error('data_inici')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group flex-fill">
                            <label for="data_fi">Data Fi</label>
                            <input type="date" name="data_fi" id="data_fi" class="@error('data_fi') is-invalid @enderror" value="{{ old('data_fi') ?? $diaSeguent }}" required>
                            @error('data_fi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group flex-fill">
                        <label for="comentaris">Comentaris</label>
                        <input type="text" name="comentaris" id="comentaris"
                            class="form-control @error('comentaris') is-invalid @enderror"
                            value="{{ old('comentaris') }}" maxlength="255">
                        @error('comentaris')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="button button--green button--margin-top">Registrar reserva</button>
        </form>
    </div>

@endsection
