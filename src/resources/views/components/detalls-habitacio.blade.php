<span class="close" onclick="hidePopup()">&times;</span>
<h3>Detalls de l'habitació {{ $habitacio->numHabitacion }}</h3>
<div class="culumna-detalls">
    <h5>Informació de l'habitació</h5>
    <ul class="llista-detalls">
        <li><b>Tipus:</b> {{ $habitacio->tipus }}</li>
        <li><b>Estat:</b> {{ $habitacio->getEstat() }}</li>
        <li><b>Serveis adicionals:</b>
            @if ($habitacio->serveis->isEmpty())
                <ul>
                    <li class="li-espaciat text-cursiva">Sense serveis adicionals.</li>
                </ul>
            @else
                <ul>
                    @foreach ($habitacio->serveis as $servei)
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
    @endphp

    @if ($reservaActual)
        <h5>Reserva Actual</h5>
        <ul class="llista-detalls">
            <li><b>Nom:</b> {{ $reservaActual->usuari->nom }}</li>
            <li><b>ID Reserva:</b> {{ $reservaActual->id }}</li>
            <li><b>Data Entrada:</b> {{ date('Y-m-d', strtotime($reservaActual->data_entrada)) }}</li>
            <li><b>Data Sortida:</b> {{ date('Y-m-d', strtotime($reservaActual->data_sortida)) }}</li>
            <li><b>Preu Total:</b> {{ $reservaActual->preu_total }}€</li>
        </ul>
    @elseif ($proximaReserva && $habitacio->estat === 'Lliure')
        <h5>Próxima Reserva</h5>
        <ul class="llista-detalls">
            <li><b>Nom:</b> {{ $proximaReserva->usuari->nom }}</li>
            <li><b>ID Reserva:</b> {{ $proximaReserva->id }}</li>
            <li><b>Data Entrada:</b> {{ date('Y-m-d', strtotime($proximaReserva->data_entrada)) }}</li>
            <li><b>Data Sortida:</b> {{ date('Y-m-d', strtotime($proximaReserva->data_sortida)) }}</li>
            <li><b>Preu Total:</b> {{ $proximaReserva->preu_total }}€</li>
        </ul>
    @else
        <h5>Reserva actual</h5>
        <ul class="llista-detalls">
            <li class="text-cursiva">No hi han reserves actuals ni próximes.</li>
        </ul>
    @endif
</div>
