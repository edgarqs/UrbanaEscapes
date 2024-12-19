@extends('layouts.master')

@section('title', 'Habitacions')

@section('content')

    <h1>Habitacions</h1>

    @if (session('success'))
        <div class="message-content message-content--info" id="status-message">
            {{ session('success') }}
        </div>
    @endif

    <div class="cards cards--habitacions">
        @foreach ($habitacions as $habitacio)
            <a class="card" onclick="showPopup({{ $habitacio->id }})">
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
            </a>
        @endforeach
    </div>

    {{-- Popup de detalls-habitacio.blade.php --}}
    <div id="popup" class="popup" style="display: none;">

        <div id="popup-details"><!-- AQUÍ SE METE EL COMPONENT --></div>
    </div>

    {{-- Paginació --}}
    @if ($habitacions->count())
        <nav>
            {{ $habitacions->appends(['id' => $idHotel])->links() }}
        </nav>
    @endif

@endsection
