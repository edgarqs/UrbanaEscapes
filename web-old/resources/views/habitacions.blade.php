<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Habitacions | uEscapes</title>
    <link rel="icon" href="{{ asset('img/urbana.ico') }}" type="image/x-icon">
    @vite(['resources/css/main.scss'])
</head>

<body class="bg-gray-100 text-gray-800">
    
    <div id="header1" class="m-auto bg-white shadow-md p-4"></div>    
    <div id="habitacionsdisponibles" class="m-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Habitacions</h1>
        <div class="container mx-auto p-4">
            <div class="w-full relative">
                <div class="swiper centered-slide-carousel swiper-container relative">
                    <div class="swiper-wrapper card-container" id="card-container">
                        <!-- Aquí irán las tarjetas de habitaciones -->
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
    

    <div id="footer" class="m-auto bg-white shadow-md p-4"></div>
    <div id="error-message" class="alert alert-danger hidden bg-red-100 text-red-700 p-4 rounded-lg mt-4"
        role="alert">
        No s'ha pogut conectar amb el servidor. Si us plau, torna a intentar-ho més tard.
    </div>
    @vite('resources/js/app.js')
</body>

</html>