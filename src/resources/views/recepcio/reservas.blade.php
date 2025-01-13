@extends('layouts.master')

@section('title', 'Recepció')

@section('content')
    @if (session('error'))
        <div class="message-content message-content--error" id="status-message">
            {{ session('error') }}
        </div>
    @endif
    <div class="nav">
        <h3>Afegir reserva</h3>
        <button onclick="window.location='{{ route('recepcio', ['id' => auth()->user()->hotel_id]) }}'">Tornar</button>
    </div>
    <form action="{{ route('reserves.store', ['habitacionId' => $habitacionId]) }}" method="post">
        @csrf
        <h4>Dades del client</h4>
        <div class="form-group usuariNou">
            <div class="form-group">
                <label for="dni">DNI</label>
                <input type="text" class="form-control" id="dni" name="dni" required>

                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom">

                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
        </div>
        <div class="form-group">
            <div class="dadesHabitacio">
                <h4>Dades de l'habitació</h4>
                <p>Habitació: {{ $habitacio->numHabitacion }}</p>
                <p>Tipus: {{ $habitacio->tipus }}</p>
                <p>Preu: {{ $habitacio->preu }}€</p>
                <p>Num.llits: {{ $habitacio->llits }}</p>
                <p>Num.llits supletoris: {{ $habitacio->llits_supletoris }}</p>
            </div>
            <div class="serveisHabitacio">
                <h4>Serveis</h5>
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
            <div></div>
        </div>
        </div>

        <div class="form-group">
            <div class="reserva">
                <h4>Dades de la reserva</h4>
                <div class="inici">
                    <label for="data_inici">Data inici</label>
                    <input type="date" class="form-control" id="data_inici" name="data_inici"
                        value="{{ $diaActual }}" required>
                </div>

                <div class="fi">
                    <label for="data_fi">Data fi</label>
                    <input type="date" class="form-control" id="data_fi" name="data_fi" value="{{ $diaSeguent }}"
                        required>
                </div>
            </div>

            <div class="comentaris">
                <h4>Comentaris</h4>
                <div class="form-group">
                    <textarea class="form-control" id="observacions" name="comentaris" rows="3"></textarea>
                </div>
            </div>

            <div></div>

        </div>

        <div class="submit">
            <button type="submit" class="btn btn-primary">Afegir reserva</button>
        </div>


    </form>

@endsection
<style>
    .nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .usuariSelector {
        padding-bottom: 20px;
    }

    .form-group {
        display: flex;
        justify-content: space-between;
    }

    .list-group {
        flex-direction: column;
    }

    .form-check-label {
        display: flex;
        justify-content: space-between;
    }

    .form-check-input {
        margin-left: 10px;
    }


    .submit {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
</style>
