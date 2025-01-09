@extends('layouts.master')

@section('title', $hotel->nom)

@section('content')
    <div class="contenido">

        <h1>Gestió: {{ $hotel->nom }}</h1>

        <div class="cards">

            <a href="{{ route('hotel.habitacions', ['id' => request()->query('id')]) }}">
                <div class="card card--resum-hotels">
                    <h2 class="card__header">Habitacions Ocupades</h2>
                    <div class="counter">
                        <h3 class="counter__habitacions">{{ $habitacionsOcupades }}&nbsp;<span
                                class="habitacions">/{{ $habitacionsTotals }}</span></h3>
                        <h3 class="counter__percentatges">{{ $habitacionsOcupadesPercentatge }}<span class="habitacions">%</span></h3>
                    </div>
                </div>
            </a>

            <a href="{{ route('hotel.habitacions', ['id' => request()->query('id')]) }}">
                <div class="card card--resum-hotels">
                    <h2 class="card__header">Habitacions Lliures</h2>
                    <div class="counter">
                        <h3 class="counter__habitacions">{{ $habitacionsLliures }}&nbsp;<span
                                class="habitacions">/{{ $habitacionsTotals }}</span></h3>
                        <h3 class="counter__percentatges">{{ $habitacionsLliuresPercentatge }}<span class="habitacions">%</span></h3>
                    </div>
                </div>
            </a>

            <a href="{{ route('hotel.habitacions', ['id' => request()->query('id')]) }}">
                <div class="card card--resum-hotels">
                    <h2 class="card__header">Checkins Pendents</h2>
                    <h3 class="counter__habitacions">{{ $checkinsPendents }}</h3>
                </div>
            </a>

            <a href="{{ route('reservas.checkins') }}" class="button">
                Llistat de Check-Ins Pendents
            </a>

        </div>

    </div>
@endsection
