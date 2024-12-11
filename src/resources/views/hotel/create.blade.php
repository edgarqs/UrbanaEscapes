@extends('layouts.master')

@section('title', 'Crea Hotel')

@section('content')

<div class="form card">
    <h3 class="center">Registrar nou hotel</h3>
    <form action="{{ route('hotel.store') }}" method="post">
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

        <button type="submit" class="button primary margin-top">Guardar</button>
    </form>
</div>
@endsection
