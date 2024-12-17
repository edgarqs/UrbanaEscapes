<h3>Detalls de l'habitació {{ $habitacio->numHabitacion }}</h3>
<ul class="details-list">
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
                    <li>{{ $servei->nom }} <span class="text-cursiva">( {{ $servei->preu }}€ /dia )</span></li>
                @endforeach
            </ul>
        @endif
    </li>
    <li><b>Reserva actual:</b>
        @if ($habitacio->reservas->isEmpty() || $habitacio->estat === 'lliure')
            <ul>
                <li class="text-cursiva">No hi han reserves actuals.</li>
            </ul>
        @else
            @php
                $reservaActual = $habitacio->reservas->first();
            @endphp
            <ul>
                <li>{{ $reservaActual->usuari->nom }}</li>
            </ul>
        @endif
    </li>
</ul>
