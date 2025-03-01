@extends('layouts.master')

@section('title', $hotel->nom)

@section('content')
    <div class="contenido">

        <h1>Gestió: {{ $hotel->nom }}</h1>

        <div class="cards">

            <a href="{{ route('hotel.habitacions', ['id' => request()->query('id'), 'estat' => 'Ocupada']) }}">
                <div class="card card--resum-hotels">
                    <h2 class="card__header">Habitacions Ocupades</h2>
                    <div class="counter">
                        <h3 class="counter__habitacions">{{ $habitacionsOcupades }}&nbsp;<span
                                class="habitacions">/{{ $habitacionsTotals }}</span></h3>
                        <h3 class="counter__percentatges">{{ $habitacionsOcupadesPercentatge }}<span
                                class="habitacions">%</span></h3>
                    </div>
                </div>
            </a>

            <a href="{{ route('hotel.habitacions', ['id' => request()->query('id'), 'estat' => 'Lliure']) }}">
                <div class="card card--resum-hotels">
                    <h2 class="card__header">Habitacions Lliures</h2>
                    <div class="counter">
                        <h3 class="counter__habitacions">{{ $habitacionsLliures }}&nbsp;<span
                                class="habitacions">/{{ $habitacionsTotals }}</span></h3>
                        <h3 class="counter__percentatges">{{ $habitacionsLliuresPercentatge }}<span
                                class="habitacions">%</span></h3>
                    </div>
                </div>
            </a>

            <a href="{{ route('hotel.habitacions', ['id' => request()->query('id'), 'estat' => 'Bloquejada']) }}">
                <div class="card card--resum-hotels">
                    <h2 class="card__header">Habitacions bloquejades</h2>
                    <h3 class="counter__habitacions">{{ $habitacionsBloquejades }}</h3>
                </div>
            </a>
        </div>

        @if (auth()->user()->hasRole('administrador'))
            <div class="cards">

                <a href="{{ route('recepcio', ['id' => request()->query('id')]) }}">
                    <div class="card card--resum-hotels card--botons-gestioHotel">
                        <h2 class="card__header"><span class="material-symbols-outlined">event</span> Recepció</h2>
                    </div>
                </a>

                <a href="{{ route('reservas.checkins', ['id' => request()->query('id')]) }}">
                    <div class="card card--resum-hotels card--botons-gestioHotel">
                        <h2 class="card__header"><span class="material-symbols-outlined">check_box</span> Pròximes Reserves
                        </h2>
                    </div>
                </a>

                <a href="{{ route('hotel.configHotel', ['id' => request()->query('id')]) }}">
                    <div class="card card--resum-hotels card--botons-gestioHotel">
                        <h2 class="card__header"><span class="material-symbols-outlined">settings</span> Configuració</h2>
                    </div>
                </a>

            </div>
        @endif


    </div>
@endsection
