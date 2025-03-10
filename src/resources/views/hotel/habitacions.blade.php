@extends('layouts.master')

@section('title', 'Habitacions')

@section('content')

    @if (session('success'))
        <div class="message-content message-content--info" id="status-message">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="message-content message-content--error" id="status-message">
            {{ session('error') }}
        </div>
    @endif

    @php
    $estado = request()->query('estat', 'totes');
    $titulo = 'Habitacions';
    if ($estado === 'Lliure') {
        $titulo = 'Habitacions Lliures';
    } elseif ($estado === 'Bloquejada') {
        $titulo = 'Habitacions Bloquejades';
    } elseif ($estado === 'Ocupada') {
        $titulo = 'Habitacions Ocupades';
    }
    @endphp

    <h1>{{ $titulo }}</h1>


    <div class="cards cards--habitacions">
        @foreach ($habitacions as $habitacio)
            <a class="card card--tamany-fix" onclick="showPopup({{ $habitacio->id }})">
                <h2 class="card__header">{{ $habitacio->numHabitacion }}</h2>
                <div class="card__body">
                    <p>{{ $habitacio->tipus }}</p>
                    <p>Estat: {{ $habitacio->getEstat() }}</p>
                    <div class="contenedor-dosBotones">
                        {{-- Botón de checkin o botón de checkout --}}
                        @php
                            $hoy = \Carbon\Carbon::today()->format('Y-m-d');
                        @endphp
                        @if ($habitacio->estat === 'Bloquejada')
                        <form action="{{ route('habitacions.desbloquejar', $habitacio->id) }}" method="POST">
                            @csrf
                            <button class="button button--primary">
                                <span class="material-symbols-outlined">lock_open</span>Desbloquejar
                            </button>
                        </form>
                    @endif
                    @if ($habitacio->estat === 'Lliure')
                        <form action="{{ route('habitacions.bloquejar', $habitacio->id) }}" method="POST">
                            @csrf
                            <button class="button button--orange">
                                <span class="material-symbols-outlined">mop</span>Bloquejar
                            </button>
                        </form>
                    @endif
                        @if ($habitacio->reservas()->where('estat', 'Reservada')->exists() && $habitacio->estat === 'Lliure')
                            <form action="{{ route('habitacions.checkin', $habitacio->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="button button--green no-popup">
                                    <span class="material-symbols-outlined">login</span>Check-In
                                </button>
                            </form>
                        @endif
                        @if ($habitacio->reservas()->where('estat', 'Checkin')->exists() && $habitacio->estat === 'Ocupada')
                            <form action="{{ route('habitacions.checkout', $habitacio->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="button button--red no-popup">
                                    <span class="material-symbols-outlined">logout</span>Check-Out
                                </button>
                            </form>
                        @endif
                        @if ($habitacio->reservas()->where('estat', 'Checkin')->exists() && $habitacio->estat === 'Bloquejada')
                        <form action="{{ route('habitacions.checkin', $habitacio->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="button button--green">
                                <span class="material-symbols-outlined">login</span>Check-In
                            </button>
                        </form>
                        @endif
                    </div>
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
            {{ $habitacions->appends(request()->query())->links() }}
        </nav>
    @endif

@endsection