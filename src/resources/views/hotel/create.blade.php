@extends('layouts.master')

@section('title', 'Nou Hotel')

@section('content')

<div class="form card" id="form-step-1">
    <h3 class="center">Registrar nou hotel</h3>
    <form id="form-step-1-fields">
        @csrf
        <!-- Primera fila -->
        <div class="form-row d-flex">
            <div class="form-group flex-fill mr-3">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" minlength="5" maxlength="30" required>
                @error('nom')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Segunda fila -->
        <div class="form-row d-flex">
            <div class="form-group flex-fill">
                <label for="adreca">Direcció</label>
                <input type="text" name="adreca" id="adreca" class="form-control @error('adreca') is-invalid @enderror" value="{{ old('adreca') }}" maxlength="40" required>
                @error('adreca')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <!-- Tercera fila -->
        <div class="form-row d-flex">
            <div class="form-group flex-fill mr-3">
                <label for="ciutat">Ciutat</label>
                <input type="text" name="ciutat" id="ciutat" class="form-control @error('ciutat') is-invalid @enderror" value="{{ old('ciutat') }}" maxlength="50" required>
                @error('ciutat')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group flex-fill">
                <label for="pais">País</label>
                <input type="text" name="pais" id="pais" class="form-control @error('pais') is-invalid @enderror" value="{{ old('pais') }}" maxlength="23" required>
                @error('pais')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Cuarta fila -->
        <div class="form-row d-flex">
            <div class="form-group flex-fill mr-3">
                <label for="email">Correu electrònic</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" maxlength="50" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Quinta fila -->
        <div class="form-row d-flex">
            <div class="form-group flex-fill">
                <label for="telefon">Telèfon</label>
                <input type="tel" name="telefon" id="telefon" class="form-control @error('telefon') is-invalid @enderror" value="{{ old('telefon') }}" minlength="6" maxlength="15" required>
                @error('telefon')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="button" class="button button--primary button--margin-top" onclick="showStep2()">Següent</button>
    </form>
</div>

<div class="form card" id="form-step-2" style="display: none;">
    <h3 class="center">Detalls del nou hotel</h3>
    <form id="form-step-2-fields" action="{{ route('hotel.store') }}" method="post">
        @csrf
        <input type="hidden" name="nom" id="hidden-nom">
        <input type="hidden" name="adreca" id="hidden-adreca">
        <input type="hidden" name="ciutat" id="hidden-ciutat">
        <input type="hidden" name="pais" id="hidden-pais">
        <input type="hidden" name="email" id="hidden-email">
        <input type="hidden" name="telefon" id="hidden-telefon">

        <!-- Primera fila -->
        <div class="form-row d-flex">
            <div class="form-group flex-fill mr-3">
                <label for="clients">Clients</label>
                <input type="number" name="clients" id="clients"
                    class="form-control @error('clients') is-invalid @enderror" value="{{ old('clients', 50) }}"
                    min="0" placeholder="Quants clients vols crear per al hotel?" required>
                @error('clients')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Segunda fila -->
        <div class="form-row d-flex">
            <div class="form-group flex-fill">
                <label for="habitacions">Habitacions</label>
                <input type="number" name="habitacions" id="habitacions"
                    class="form-control @error('habitacions') is-invalid @enderror"
                    value="{{ old('habitacions', 100) }}" min="0" placeholder="Quantes habitacions vols crear?"
                    required>
                @error('habitacions')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Tercera fila -->
        <div class="form-row d-flex">
            <div class="form-group flex-fill">
                <label for="reserves">Reserves</label>
                <input type="number" name="reserves" id="reserves"
                    class="form-control @error('reserves') is-invalid @enderror" value="{{ old('reserves', 50) }}"
                    min="0" placeholder="Quantes reserves vols crear?" required>
                @error('reserves')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="button" class="button button--secondary button--margin-top" onclick="showStep1()">Volver</button>
        <button type="submit" class="button button--primary button--margin-top">Guardar</button>
    </form>
</div>

<script>
    function showStep2() {
        // Validate step 1 fields
        const step1Fields = document.querySelectorAll('#form-step-1-fields input');
        let valid = true;
        step1Fields.forEach(field => {
            if (!field.checkValidity()) {
                field.reportValidity();
                valid = false;
            }
        });

        if (valid) {
            // Hide step 1
            document.getElementById('form-step-1').style.display = 'none';

            // Show step 2
            document.getElementById('form-step-2').style.display = 'block';

            // Copy values from step 1 to hidden fields in step 2
            document.getElementById('hidden-nom').value = document.getElementById('nom').value;
            document.getElementById('hidden-adreca').value = document.getElementById('adreca').value;
            document.getElementById('hidden-ciutat').value = document.getElementById('ciutat').value;
            document.getElementById('hidden-pais').value = document.getElementById('pais').value;
            document.getElementById('hidden-email').value = document.getElementById('email').value;
            document.getElementById('hidden-telefon').value = document.getElementById('telefon').value;
        }
    }

    function showStep1() {
        // Hide step 2
        document.getElementById('form-step-2').style.display = 'none';

        // Show step 1
        document.getElementById('form-step-1').style.display = 'block';
    }
</script>

@endsection
