@extends('layouts.master')

@section('title', 'Habitacions')

@section('content')

    <h1>Habitacions</h1>

    {{-- <p>Hotel ID: {{ $idHotel }}</p> --}}
    @if (session('success'))
    <div class="message-content message-content--success" id="status-message">
        {{ session('success') }}
    </div>
@endif
    <div class="cards cards--habitacions">

    @foreach ($habitacions as $habitacio)
        <div class="card">
            <h2 class="card__header">{{ $habitacio->numHabitacion }}</h2>
            <div class="card__body">
                <p>{{ $habitacio->tipus }}</p>
                <p>Estat: {{ $habitacio->getEstat() }}</p>
                @if ($habitacio->reservas()->where('estat', 'reservada')->exists() && $habitacio->estat !== 'ocupada')
                    <form action="{{ route('habitacions.checkin', $habitacio->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="button">Check-In</button>
                    </form>
                @endif
                @if ($habitacio->reservas()->where('estat', 'checkin')->exists() && $habitacio->estat === 'ocupada')
                    <form action="{{ route('habitacions.checkout', $habitacio->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="button">Check-Out</button>
                    </form>
                @endif
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
