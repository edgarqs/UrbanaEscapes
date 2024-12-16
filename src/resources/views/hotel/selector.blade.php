@extends('layouts.master')

@section('title', 'Hotels')

@section('content')

    <h1>Sel·leciona l'hotel a consultar</h1>

    {{-- Mensaje tras creación del hotel --}}
    @if (session()->has('status'))
        <div class="message-content message-content--success" id="status-message">
            <p> {{ session('status') }} </p>
        </div>
    @endif

    {{-- Mensaje de error --}}
    @if ($errors->any())
        <div class="message-content message-content--error" id="status-message">
            <p>{{ $errors->first() }}</p>
        </div>
    @endif

    <div class="cards">

        @foreach ($hotels as $hotel)
            <div class="card">
                <h2 class="card__header">{{ $hotel->nom }}</h2>
                <div class="card__body">
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
