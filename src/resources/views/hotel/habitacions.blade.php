@extends('layouts.master')

@section('title', 'Habitacions')

@section('content')

    <h1>Habitacions</h1>

    {{-- <p>Hotel ID: {{ $idHotel }}</p> --}}

    <div class="cards cards--habitacions">

    @foreach ($habitacions as $habitacio)
        <div class="card">
            <h2 class="card__header">{{ $habitacio->numHabitacion }}</h2>
            <div class="card__body">
                <p>{{ $habitacio->tipus }}</p>
            </div>
        </div>
    @endforeach

    </div>

    @if ($habitacions->count())
        <nav>
            {{ $habitacions->appends(['id' => $idHotel])->links() }} 
        </nav>
    @endif

@endsection
