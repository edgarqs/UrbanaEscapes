@extends('layouts.master')

@section('title', 'Hotels')

@section('content')

    <h1>Selecciona l'hotel a consultar</h1>

    {{-- Mensaje tras creación del <hotel --}}
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

    @if ($hotels->isEmpty())
        <div class="messages-content">
            <p class="messages"><span class="material-symbols-outlined">error</span>No hi han hotels per consultar. <a href="{{ route('hotel.create') }}">Crea el primer hotel.</a></p>
        </div>
    @else
        <div class="cards">
            @foreach ($hotels as $hotel)
                <div class="card">
                    <h2>{{ $hotel->nom }}</h2>
                    <p>{{ $hotel->adreca }}</p>
                    <a href="{{ route('hotel.home', ['id' => $hotel->id]) }}" class="button">Consultar</a>
                </div>
            @endforeach
        </div>
    @endif

@endsection
