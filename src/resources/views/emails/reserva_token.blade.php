<!DOCTYPE html>
<html>

<head>
    <title>Token de Reserva</title>
</head>

<body>
    <h1>Detalls de la Reserva</h1>
    <p>Hola {{ $reserva->usuari->nom }},</p>
    <p>El teu token de reserva és: <strong>{{ $token }}</strong></p>
    <p>Reserva ID: {{ $reserva->id }}</p>
    <p>Data d'Entrada: {{ $reserva->data_entrada->format('d-m-Y') }}</p>
    <p>Data de Sortida: {{ $reserva->data_sortida->format('d-m-Y') }}</p>
    <p>Gràcies per confiar en nosaltres.</p>
</body>

</html>
