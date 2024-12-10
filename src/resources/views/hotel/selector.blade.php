@extends('layouts.master')

@section('title', 'Hotels')

@section('content')

    <h1 class="h1">Sel·leciona l'hotel a consultar</h1>

    @if (session()->has('status'))
        <div class="w3-panel w3-pale-green">
            <p> {{ session('status') }} </p>
        </div>
    @endif

    <div class="cards">

        @foreach ($hotels as $hotel)
            <div class="card">
                <h2 class="card-header">{{ $hotel->nom }}</h2>
                <div class="card-body">
                    <p>{{ $hotel->adreca }}<br>{{ $hotel->ciutat }}, {{ $hotel->pais }}</p>
                </div>
                <form action="{{ route('hotel.home') }}" method="GET">
                    <input type="hidden" name="id" value="{{ $hotel->id }}">
                    <button type="submit" class="button primary">Seleccionar</button>
                </form>
            </div>
        @endforeach
    </div>

@endsection
