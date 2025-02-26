@extends('layouts.master')

@section('title', 'Nova Notícia')

@section('content')

    <div class="form card">
        <h3 class="center">Crear Notícia</h3>
        <form action="{{ route('noticies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Primera fila -->
            <div class="form-row d-flex">
                <div class="form-group flex-fill mr-3">
                    <label for="titol">Títol</label>
                    <input type="text" name="titol" id="titol"
                        class="form-control @error('titol') is-invalid @enderror" value="{{ old('titol') }}" minlength="5"
                        maxlength="30" required>
                    @error('titol')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Segona fila -->
            <div class="form-row d-flex">
                <div class="form-group flex-fill">
                    <label for="descripcio-curta">Descripció Curta</label>
                    <input type="text" name="descripcio-curta" id="descripcio-curta"
                        class="form-control @error('descripcio-curta') is-invalid @enderror"
                        value="{{ old('descripcio-curta') }}" maxlength="40" required>
                    @error('descripcio-curta')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Tercera fila -->
            <div class="form-row d-flex">
                <div class="form-group flex-fill mr-3">
                    <label for="descripcio-llarga">Descripció Llarga</label>
                    <textarea name="descripcio-llarga" id="descripcio-llarga"
                        class="form-control @error('descripcio-llarga') is-invalid @enderror" rows="5" required>{{ old('descripcio-llarga') }}</textarea>
                    @error('descripcio-llarga')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Quarta fila -->
            <div class="form-row d-flex">
                <div class="form-group flex-fill mr-3">
                    <label for="publicada">Publicada</label>
                    <input type="hidden" name="publicada" value="0">
                    <input type="checkbox" name="publicada" id="publicada"
                        class="form-control @error('publicada') is-invalid @enderror" value="1"
                        {{ old('publicada') ? 'checked' : '' }}>
                    @error('publicada')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Quinta fila -->
            <div class="form-row d-flex">
                <div class="form-group flex-fill mr-3">
                    <label for="hotels">Visibilitat per Hotels</label>
                    <select name="hotels[]" id="hotels" class="form-control @error('hotels') is-invalid @enderror"
                        multiple>
                        @foreach ($hotels as $hotel)
                            <option value="{{ $hotel->id }}">{{ $hotel->nom }}</option>
                        @endforeach
                    </select>
                    @error('hotels')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Sexta fila -->
            <div class="form-row d-flex">
                <div class="form-group flex-fill mr-3">
                    <label for="fotos">Fotos</label>
                    <input type="file" name="fotos[]" id="fotos"
                        class="form-control @error('fotos') is-invalid @enderror" multiple>
                    @error('fotos')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="button button--primary button--margin-top">Afegir</button>
        </form>
    </div>

@endsection
