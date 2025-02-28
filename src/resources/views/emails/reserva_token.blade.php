<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valora la teva estada</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .email-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }

        h1 {
            color: #333333;
            font-weight: 600;
            font-size: 24px;
            margin-bottom: 15px;
        }

        p {
            color: #555555;
            line-height: 1.6;
            font-size: 16px;
        }

        .button {
            display: inline-block;
            padding: 12px 25px;
            margin-top: 25px;
            font-size: 18px;
            color: #ffffff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #0056b3;
        }

        strong {
            color: #333333;
        }

        footer {
            margin-top: 40px;
            font-size: 14px;
            color: #777777;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <img src="{{ asset('img/urbana_logo-sinFondo.avif') }}" alt="Logo Hotel" class="logo">
        <h1>Valora la teva estada al hotel</h1>
        <p>Hola <strong>{{ $reserva->usuari->nom }}</strong>,</p>
        <p>Gràcies per allotjar-te al nostre hotel. Ens agradaria conèixer la teva opinió sobre la teva estada.</p>
        <p>Fes-nos saber la teva valoració i comparteix la teva experiència amb nosaltres fent clic al botó següent:</p>
        <a href="https://edgarquirante.edgarqs.dev/feedback/{{ $token }}" class="button">Donar Feedback</a>
        <p><strong>Data d'entrada:</strong> {{ $reserva->data_entrada->format('d-m-Y') }}</p>
        <p><strong>Data de sortida:</strong> {{ $reserva->data_sortida->format('d-m-Y') }}</p>
        <p>Ens agradaria saber com podem millorar els nostres serveis per fer la teva propera estada encara millor.</p>
        <footer>
            <p>Si tens qualsevol dubte o necessitat, no dubtis en contactar-nos.</p>
        </footer>
    </div>
</body>

</html>
