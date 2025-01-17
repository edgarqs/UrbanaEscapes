<span class="close" onclick="hidePopup()">&times;</span>
<h3>Detalls de l'habitació {{ $habitacio->numHabitacion }}</h3>
<div class="culumna-detalls">
    <h5>Informació de l'habitació</h5>
    <ul class="llista-detalls">
        <li><b>Tipus:</b> {{ $habitacio->tipus }}</li>
        <li><b>Estat:</b> {{ $habitacio->getEstat() }}</li>
        <li><b>Serveis adicionals:</b>
            @if ($reserves->serveis->isEmpty())
                <ul>
                    <li class="li-espaciat text-cursiva">Sense serveis adicionals.</li>
                </ul>
            @else
                <ul>
                    @foreach ($reserves->serveis as $servei)
                        <li class="li-espaciat">{{ $servei->nom }} <span class="text-cursiva">( {{ $servei->preu }}€
                                )</span></li>
                    @endforeach
                </ul>
            @endif
        </li>
        <li><b>Capacitat persones:</b> {{ $habitacio->llits + $habitacio->llits_supletoris }}</li>
    </ul>
</div>
<div class="culumna-detalls">
    @php
        $reservaActual = $habitacio->reservas()->where('estat', 'Checkin')->first();
        $proximaReserva = $habitacio->reservas()->where('estat', 'Reservada')->orderBy('data_entrada')->first();
        $hoy = \Carbon\Carbon::today()->format('Y-m-d');
    @endphp

    @if ($reservaActual)
        <h5>Reserva Actual</h5>
        <ul class="llista-detalls">
            <li><b>Nom:</b> {{ $reservaActual->usuari->nom }}</li>
            <li><b>ID Reserva:</b> {{ $reservaActual->id }}</li>
            <li><b>Data Entrada:</b> {{ date('Y-m-d', strtotime($reservaActual->data_entrada)) }}</li>
            <li><b>Data Sortida:</b> {{ date('Y-m-d', strtotime($reservaActual->data_sortida)) }}</li>
            <li><b>Preu Total:</b> {{ $reservaActual->preu_total }}€</li>
            <li><b>Serveis:</b>
                <ul>
                    @foreach ($reservaActual->serveis as $servei)
                        <li>{{ $servei->nom }} ({{ $servei->preu }}€)</li>
                    @endforeach
                </ul>
            </li>
        </ul>
    @elseif ($proximaReserva && $habitacio->estat === 'Lliure')
        <h5>Próxima Reserva</h5>
        <ul class="llista-detalls">
            <li><b>Nom:</b> {{ $proximaReserva->usuari->nom }}</li>
            <li><b>ID Reserva:</b> {{ $proximaReserva->id }}</li>
            <li><b>Data Entrada:</b> {{ date('Y-m-d', strtotime($proximaReserva->data_entrada)) }}</li>
            <li><b>Data Sortida:</b> {{ date('Y-m-d', strtotime($proximaReserva->data_sortida)) }}</li>
            <li><b>Preu Total:</b> {{ $proximaReserva->preu_total }}€</li>
            <li><b>Serveis:</b>
                <ul>
                    @foreach ($proximaReserva->serveis as $servei)
                        <li>{{ $servei->nom }} ({{ $servei->preu }}€)</li>
                    @endforeach
                </ul>
            </li>
        </ul>
    @else
        <h5>Reserva actual</h5>
        <ul class="llista-detalls">
            <li class="text-cursiva">No hi han reserves actuals ni próximes.</li>
        </ul>
    @endif
</div>
<div>
    <div class="contenedor-dosBotones">
        {{-- Botón de checkin o botón de checkout --}}
        @if ($habitacio->reservas()->where('estat', 'Reservada')->exists() && $habitacio->estat === 'Lliure')
            @php
                $reservaHoy = $habitacio->reservas()->where('estat', 'Reservada')->where('data_entrada', $hoy)->first();
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
    </div>
</div>