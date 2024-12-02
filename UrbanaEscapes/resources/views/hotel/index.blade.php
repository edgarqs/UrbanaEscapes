@extends('layouts.master')

@section('title', 'Hotels')

@section('content')
    <div class="index">
        <a href="{{ route('hotel.create') }}" class="btn btn-primary">Crea Hotel</a>
    </div>
    <div class="hotels">
        <div class="selector">
            <form>
                <select name="hotel">
                    @foreach ($hotels as $hotel)
                        <option value="{{ $hotel->id }}">{{ $hotel->nom }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="cards">
            <div class="item">
                <h1>Habitacions ocupades</h1>
                
            </div>
            <div class="item">
                <h1>Habitacions lliures</h1>
            </div>
            <div class="item">
                <h1>Habitacions reservades</h1>
            </div>
        </div>
    </div>
@endsection
