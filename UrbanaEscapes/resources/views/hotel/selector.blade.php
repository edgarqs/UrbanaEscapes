@extends('layouts.master')

@section('title', 'Hotels')

@section('content')
    <div class="home">
        <a href="{{ route('hotel.create') }}" class="btn btn-primary">Crea Hotel</a>
    </div>
    <div class="hotels">
        <div class="selector">
            <form action="{{ route('hotel.home') }}" method="GET">
                <select name="id">
                    @foreach ($hotels as $hotel)
                        <option value="{{ $hotel->id }}">{{ $hotel->nom }}</option>
                    @endforeach
                </select>
                <button type="submit">Selecciona</button>
            </form>
        </div>
    </div>
@endsection