@extends('layouts.master')

@section('title', 'Afegir Reserva')

@section('content')
    <h1>Afegir Reserva</h1>


    <div class="filtres">
        <div class="perTipus">

        </div>
        <div class="perCapacitat">

        </div>
        <div class="perPreu">

        </div>
        <div class="perEstat">

        </div>
    </div>


    <div class="cards cards--habitacions">
        @foreach ($habitacions as $habitacio)
            <a class="card">
                <h2 class="card__header">Habitació:{{ $habitacio->numHabitacion }}</h2>
                <div class="card__body">
                    <p>{{ $habitacio->tipus }}</p>
                    <p>Estat: {{ $habitacio->getEstat() }}</p>
                    <p>Preu: {{ $habitacio->preu }}€</p>
                    <p>Capacitat: {{ $habitacio->llits + $habitacio->llits_supletoris }}</p>
                    <button class="button button--primary">Afegir reserva</button>
                </div>
            </a>
        @endforeach


    </div>


@endsection
