@extends('layouts.master')

@section('content')
    <div class="contenido">

        <h2 class="h2">Gestió de l'hotel</h2>

        <div class="cards">
            <div class="card">
                <h2 class="card-header">Habitacions Ocupades</h2>
                <h3 class="counter-habitacions">{{ $hab_ocupada }}&nbsp;<span class="habitacions">/{{ $habitacionsTotals }}</span></h3>
            </div>
            <div class="card">
                <h2 class="card-header">Habitacions Lliures</h2>
                <h3 class="counter-habitacions">{{ $hab_lliures }}&nbsp;<span class="habitacions">/{{ $habitacionsTotals }}</span></h3>
            </div>
            <div class="card">
                <h2 class="card-header">Checkins Pendents</h2>
                <h3 class="counter-habitacions">{{ $hab_pendent }}&nbsp;<span class="habitacions">/{{ $habitacionsTotals }}</span></h3>
            </div>
        </div>

    </div>

@endsection
