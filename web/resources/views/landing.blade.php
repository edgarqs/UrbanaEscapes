<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | uEscapes</title>
    <link rel="icon" href="{{ asset('img/urbana.ico') }}" type="image/x-icon">
    @vite(['resources/css/main.scss'])
</head>

<body>

    <div id="header" class="m-auto"></div>
    <div id="hero" class="m-auto"></div>
    <div id="valorscorporatius" class="m-auto"></div>
    <div id="ofertas" class="m-auto"></div>
    <div id="noticies" class="m-auto"></div>
    <div id="footer" class="m-auto"></div>
    
    @vite('resources/js/app.js')
</body>

</html>
