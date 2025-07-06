<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Iconos Google Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    {{-- * <link rel="stylesheet" href="{{ asset('css/main.css') }}"> No necesario con vite --}}
    @vite(['resources/css/main.scss'])
    <link rel="icon" href="{{ asset('img/urbana.ico') }}" type="image/x-icon">
    <title>Login | uEscapes</title>
</head>

<body>

    <div class="form card" id="login-form">
        <h3 class="center">Iniciar Sessió</h3>
        
        <!-- Alerta de demo -->
        <div class="alert alert-info demo-alert" style="background-color: #d1ecf1; color: #0c5460; padding: 12px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #bee5eb;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span class="material-symbols-outlined" style="font-size: 20px;">info</span>
                <div>
                    <strong>Demo Mode</strong><br>
                    <small>Usuari: <code>admin</code> | Contrasenya: <code>admin</code></small>
                </div>
            </div>
        </div>
        
        <form action="{{ route('login.post') }}" method="post">
            @csrf
            <!-- Primera fila -->
            <div class="form-row d-flex">
                <div class="form-group flex-fill mr-3">
                    <label for="nom">Usuari</label>
                    <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', 'admin') }}" maxlength="30" placeholder="user@urbanaescapes.com" required>
                </div>
            </div>

            <!-- Segunda fila -->
            <div class="form-row d-flex">
                <div class="form-group flex-fill">
                    <label for="password">Contrasenya</label>
                    <input type="password" name="password" id="password" class="form-control @error('nom') is-invalid @enderror" value="{{ old('password', 'admin') }}" maxlength="50" required>
                </div>
            </div>

            @if ($errors->has('nom'))
            <div class="error-container">
                @error('nom')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            @endif

            <button type="submit" class="button button--primary button--margin-top">Iniciar Sessió</button>
        </form>
    </div>

</body>

</html>
