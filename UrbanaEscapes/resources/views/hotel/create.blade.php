@extends('layouts.master')

@section('title', 'Crea Hotel')

@section('content')
<a href="{{ route('hotel.index') }}">Cancelar</a>
<div class="form">
    <form action="{{ route('hotel.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="address">Dirección</label>
            <input type="text" name="adreca" id="adreca" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="address">Ciutat</label>
            <input type="text" name="ciutat" id="ciutat" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="address">Pais</label>
            <input type="text" name="pais" id="pais" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="telefon">Teléfono</label>
            <input type="text" name="telefon" id="telefon" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection