<div>
   <h2>Detall de la reserva</h2>
   <p>Número d'Habitació: {{ $reserva->habitacion->numHabitacion }}</p>
   <p>Tipus: {{ $reserva->habitacion->tipo }}</p>
   <p>Estat: {{ $reserva->habitacion->estat }}</p>


   <h3>Detall del Client</h3>
   <p>Nom: {{ $reserva->usuari->nom }}</p>
   <p>Email: {{ $reserva->usuari->email }}</p>


   <h3>Detall d'Estada</h3>
   <p>Data d'Entrada: {{ $reserva->data_entrada->format('d-m-Y') }}</p>
   <p>Data de Sortida: {{ $reserva->data_sortida->format('d-m-Y') }}</p>


   <h3>Detall de Facturació</h3>
   <p>Preu Total: {{ $reserva->preu_total }} €</p>
   <p>Comentaris: {{ $reserva->comentaris }}</p>


   <h3>Detalls de Pagament</h3>
   <p>Estat de Pagament: {{ $reserva->estat }}</p>
</div>
