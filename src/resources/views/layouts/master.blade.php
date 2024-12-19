<!doctype html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Iconos Google Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    {{--* <link rel="stylesheet" href="{{ asset('css/main.css') }}"> No necesario con vite --}}
    @vite(['resources/css/main.scss'])
    <link rel="icon" href="{{ asset('img/urbana.ico') }}" type="image/x-icon">
    <title>@yield('title')</title>
</head>

<body>
    
    <div class="layout">
        <!-- Menú lateral -->
        <aside class="sidebar">
            <img src="{{ asset('img/urbana_logo-sinFondo.avif') }}" alt="logo urbana escapes con icono de una cama" onclick="window.location.href='{{ route('hotel.selector') }}';">
            <ul>
                <!-- Gestió de l'hotel -->
                <li>
                    @if (auth()->user()->hasRole('administrador'))
                    <a href="{{ route('hotel.selector') }}" class="{{ Route::currentRouteNamed('hotel.home') ? 'active' : '' }}">
                        <span class="material-symbols-outlined">analytics</span>Gestió de l'hotel
                    </a>
                    @elseif (auth()->user()->hasRole('recepcionista'))
                        <a href="{{ route('hotel.home', ['id' => auth()->user()->hotel_id]) }}" class="{{ Route::currentRouteNamed('hotel.home') ? 'active' : '' }}">
                            <span class="material-symbols-outlined">analytics</span>Gestió de l'hotel
                        </a>
                    @endif
                </li>


                <!-- Crear Hotel -->
                @if (auth()->user()->hasRole('administrador'))
                    <li><a href="{{ route('hotel.create') }}" class="{{ Route::currentRouteNamed('hotel.create') ? 'active' : '' }}"><span class="material-symbols-outlined">add</span>Crear Hotel</a></li>
                @endif
                
                <!-- Tornar (/) -->
                <li class="separacion"><a href="{{ route('hotel.selector') }}"><span class="material-symbols-outlined">arrow_back</span>Tornar</a></li>

                <!-- Tancar sessió -->
                <li><a href="{{ route('logout') }}"><span class="material-symbols-outlined">logout</span>Tancar la sessió</a></li>
            </ul>
        </aside>

        <!-- Contenido principal -->
        <main class="main-content">
            <div>
                @yield('content')
            </div>
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
