<!doctype html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Iconos Google Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('img/urbana.ico') }}" type="image/x-icon">
    <title>@yield('title')</title>
</head>

<body>

    <div class="layout">
        <!-- Menú lateral -->
        <aside class="sidebar">
            <img src="{{ asset('img/urbana_logo-sinFondo.png') }}" alt="">
            <ul>
                <li><a href="{{ route('hotel.selector') }}" class="{{ Route::currentRouteNamed('hotel.home') ? 'active' : '' }}"><span class="material-symbols-outlined">analytics</span>Gestió de l'hotel</a></li>
                <li><a href="{{ route('hotel.selector') }}"><span class="material-symbols-outlined">arrow_back</span>Tornar</a></li>
            </ul>
        </aside>

        <!-- Contenido principal -->
        <main class="main-content">
            <div>
                @yield('content')
            </div>
        </main>
    </div>

</body>

</html>
