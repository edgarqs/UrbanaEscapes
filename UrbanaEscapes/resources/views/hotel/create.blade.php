@extends('layouts.master')

@section('title', 'Crea Hotel')

@section('content')
<div class="form card">
    <h3 class="h3 center">Registrar nou hotel</h3>
    <form action="{{ route('hotel.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" minlength="5" maxlength="30" required>
        </div>
        <div class="form-group">
            <label for="address">Direcció</label>
            <input type="text" name="adreca" id="adreca" class="form-control" minlength="10" maxlength="40" required>
        </div>
        <div class="form-group">
            <label for="address">Ciutat</label>
            <input type="text" name="ciutat" id="ciutat" class="form-control" minlength="10" maxlength="50" required>
        </div>
        <div class="form-group">
            <label for="address">Païs</label>
            <input type="text" name="pais" id="pais" class="form-control" minlength="5" maxlength="23" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" maxlength="50" required>
        </div>
        <div class="form-group">
            <label for="telefon">Teléfon</label>
            <input type="tel" name="telefon" id="telefon" class="form-control" minlength="6" maxlength="15" required>
        </div>
        <button type="submit" class="button primary margin-top">Guardar</button>
    </form>
</div>
@endsection