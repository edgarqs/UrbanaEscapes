@extends('layouts.master')

@section('content')
    <div class="home">
        
        <div class="cards">
            <div class="item">
                <h1>Habitacions ocupades</h1>
                <p>{{ $hab_ocupada }}</p>
            </div>
            <div class="item">
                <h1>Habitacions lliures</h1>
                <p>{{ $hab_lliures }}</p>
            </div>
            <div class="item">
                <h1>Habitacions reservades</h1>
                <p>{{ $hab_pendent }}</p> 
            </div>
        </div>

        
    </div>
@endsection