@extends('layouts.master')

@section('title', 'Habitacions')

@section('content')

    <h1>Habitacions</h1>

    {{-- <p>Hotel ID: {{ $idHotel }}</p> --}}

    <div class="cards cardsHoteles">

    @foreach ($habitacions as $habitacio)
        <div class="card">
            <h2 class="card-header">{{ $habitacio->numHabitacion }}</h2>
            <div class="card-body">
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
