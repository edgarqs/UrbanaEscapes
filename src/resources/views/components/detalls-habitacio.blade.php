<div>
    
    <p>{{ $habitacio->llits }}</p>
    <table>
        @foreach ($habitacio->serveis as $servei)
            <td>{{ $servei->nom }}</p>
        @endforeach
    </table>
    @foreach ($habitacio->reservas as $reserva)
        <p>{{ $reserva->usuari->nom }}</p>
    @endforeach

</div>
