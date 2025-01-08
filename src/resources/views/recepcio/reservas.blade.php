@extends('layouts.master')

@section('title', 'Recepció')

@section('content')
<div class="nav">
    <h3>Afegir reserva</h3>
    <button onclick="window.location='{{ route('recepcio', ['id' => auth()->user()->hotel_id]  ) }}'">Tornar</button>
</div>
<form action="{{ route('reserves.store', ['habitacionId' => $habitacionId]) }}" method="post">
    @csrf
    <h4>Dades del client</h4>
    <div class="form-group-1">
        <div class="usuariRegistrat">
            <label for="usuari_registrat">Usuari registrat</label>
            
            <div class="formUsuariRegistrat">
                <select class="form-control" id="usuari_id" name="usuari_id">
                    {{-- IF dels usuaris selector --}}
                    @foreach ($usuaris as $usuari)
                        <option value="{{ $usuari->id }}">{{ $usuari->nom }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="usuariNou">
            <label for="usuari_nou">Usuari nou</label>
            
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
        </div>
    </div>

    <h4>Dades de l'habitació</h4>
    <div class="form-group">
        <p>Habitació: {{ $habitacio->numHabitacion }}</p>
        <p>Tipus: {{ $habitacio->tipus }}</p>
        <p>Preu: {{ $habitacio->preu }}€</p>
        <p>Num.llits: {{ $habitacio->llits }}</p>
        <p>Num.llits supletoris: {{ $habitacio->llits_supletoris }}</p>
    </div>

    <h4>Dades de la reserva</h4>
    <div class="form-group">
        <label for="data_inici">Data inici</label>
        <input type="date" class="form-control" id="data_inici" name="data_inici" required>

        <label for="data_fi">Data fi</label>
        <input type="date" class="form-control" id="data_fi" name="data_fi" required>
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

    .form-group-1 {
        display: flex;
        align-items: center;
    }
    .submit {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
</style>