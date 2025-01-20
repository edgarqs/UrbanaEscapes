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

    <h1>Habitacions</h1>


    {{-- Dialog de habitaciones --}}
    <dialog id="dialog-reservas">
        <h1>Test Dialog</h1>
    </dialog>

    <div class="cards cards--habitacions">
        @foreach ($habitacions as $habitacio)
            <a class="card" onclick="showPopup({{ $habitacio->id }})">
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
                                <span class="material-symbols-outlined">mop</span>
                            </button>
                        </form>
                    @endif
                        @if ($habitacio->reservas()->where('estat', 'Reservada')->exists() && $habitacio->estat === 'Lliure')
                            @php
                                $reservaHoy = $habitacio
                                    ->reservas()
                                    ->where('estat', 'Reservada')
                                    ->where('data_entrada', $hoy)
                                    ->first();
                            @endphp
                            @if ($reservaHoy)
                                <form action="{{ route('habitacions.checkin', $habitacio->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="button button--green">
                                        <span class="material-symbols-outlined">login</span>Check-In
                                    </button>
                                </form>
                            @endif
                        @endif
                        @if ($habitacio->reservas()->where('estat', 'Checkin')->exists() && $habitacio->estat === 'Ocupada')
                            <form action="{{ route('habitacions.checkout', $habitacio->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="button button--red">
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
