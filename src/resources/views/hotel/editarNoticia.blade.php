@extends('layouts.master')

@section('title', 'Editar Notícia')

@section('content')

    <div class="form card">
        <h3 class="center">Editar Notícia</h3>
        <form action="{{ route('noticies.update', $noticia->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Primera fila -->
            <div class="form-row d-flex">
                <div class="form-group flex-fill mr-3">
                    <label for="titol">Títol</label>
                    <input type="text" name="titol" id="titol"
                        class="form-control @error('titol') is-invalid @enderror"
                        value="{{ old('titol', $noticia->titol) }}" minlength="5" maxlength="30" required>
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
                        value="{{ old('descripcio-curta', $noticia->descripcio_curta) }}" maxlength="40" required>
                    @error('descripcio-curta')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Tercera fila -->
            <div class="form-row d-flex">
                <div class="form-group flex-fill">
                    <label for="descripcio-llarga">Descripció Llarga</label>
                    <textarea name="descripcio-llarga" id="descripcio-llarga"
                        class="form-control @error('descripcio-llarga') is-invalid @enderror" rows="5" required>{{ old('descripcio-llarga', $noticia->descripcio_llarga) }}</textarea>
                    @error('descripcio-llarga')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Quarta fila -->
            <div class="form-row d-flex align-items-center">
                <div class="form-group flex-fill mr-3">
                    <label for="publicada">Publicada</label>
                    <input type="hidden" name="publicada" value="0">
                    <input type="checkbox" name="publicada" id="publicada"
                        class="form-check-input @error('publicada') is-invalid @enderror" value="1"
                        {{ old('publicada', $noticia->publicada) ? 'checked' : '' }}>
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
                            <option value="{{ $hotel->id }}"
                                {{ in_array($hotel->id, old('hotels', $noticia->hotels->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $hotel->nom }}</option>
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

            <!-- Mostrar fotos existentes -->
            <div class="form-row d-flex">
                <div class="form-group flex-fill mr-3">
                    <label>Fotos Existents</label>
                    <div class="existing-photos">
                        @foreach ($noticia->fotos as $foto)
                            <div class="photo">
                                <img src="{{ asset('storage/noticies/' . $foto->foto) }}" alt="Foto de la notícia" class="img-thumbnail">
                                <label class="photo-delete">
                                    <input type="checkbox" name="eliminar_fotos[]" value="{{ $foto->id }}"> Eliminar
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <button type="submit" class="button button--primary button--margin-top">Guardar Canvis</button>
        </form>
    </div>

@endsection
