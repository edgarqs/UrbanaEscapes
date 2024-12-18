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
                    <li class="text-cursiva">No hi han serveis adicionals.</li>
                </ul>
            @else
                <ul>
                    @foreach ($habitacio->serveis as $servei)
                        <li class="li-espaciat">{{ $servei->nom }} <span class="text-cursiva">( {{ $servei->preu }}€ )</span></li>
                    @endforeach
                </ul>
            @endif
        </li>
        <li><b>Total de persones:</b> {{ $habitacio->llits + $habitacio->llits_supletoris }}</li>
    </ul>
</div>
<div class="culumna-detalls">
    <h5>Reserva actual</h5>
    <ul class="llista-detalls">
        @if ($habitacio->reservas->isEmpty())
            <li class="text-cursiva">No hi han reserves actuals.</li>
        @else
            @php
                $reservaActual = $habitacio->reservas->first();
            @endphp
            <li><b>Nom:</b> {{ $reservaActual->usuari->nom }}</li>
            <li><b>ID Reserva:</b> {{ $reservaActual->id }}</li>
        @endif
    </ul>
</div>
