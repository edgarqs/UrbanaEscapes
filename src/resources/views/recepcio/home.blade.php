<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    @vite(['resources/css/main.scss'])
    <link rel="icon" href="{{ asset('img/urbana.ico') }}" type="image/x-icon">
    <title>Recepció | UrbanaEscapes</title>
</head>
<body>
    <h1>Gestió de reserves</h1>
    @php
        $today = \Carbon\Carbon::today();
        $startDate = $today->copy()->subDays(15);
        $endDate = $today->copy()->addDays(15);
    @endphp
    <div class="calendar">
        <div class="calendar__header">
            <div></div>
            @for ($date = $startDate; $date <= $endDate; $date->addDay())
                <div>{{ $date->format('D j') }}</div>
            @endfor
        </div>
        @foreach ($habitacions as $habitacio)
            <div class="calendar__row">
                <div>{{ $habitacio->numHabitacion }}</div>
                @for ($date = $startDate->copy(); $date <= $endDate; $date->addDay())
                    @php
                        $reserva = $reservas->firstWhere('habitacion_id', $habitacio->id)
                                            ->where('data_entrada', '<=', $date)
                                            ->where('data_sortida', '>=', $date);
                    @endphp
                    <div class="calendar__cell" data-date="{{ $date->format('Y-m-d') }}">
                        @if ($reserva)
                            <div class="reservation" style="grid-column: span {{ $reserva->data_sortida->diffInDays($reserva->data_entrada) + 1 }}">
                                {{ $reserva->client_name }}
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
        @endforeach
    </div>
</body>
</html>