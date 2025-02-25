@extends('layouts.master')

@section('title', 'Notícies')

@section('content')
    <h1>Notícies</h1>

    <div class="noticies-table">
        <div class="noticies-table__header">
            <div class="noticies-table__header__cell">Títol</div>
            <div class="noticies-table__header__cell">Descripció Curta</div>
            <div class="noticies-table__header__cell">Publicada</div>
            <div class="noticies-table__header__cell">Accions</div>
        </div>
        @foreach ($noticies as $noticia)
            <div class="noticies-table__row">
                <div class="noticies-table__row__cell">{{ $noticia->titol }}</div>
                <div class="noticies-table__row__cell">{{ $noticia->descripcio_curta }}</div>
                <div class="noticies-table__row__cell">{{ $noticia->publicada ? 'Sí' : 'No' }}</div>
                <div class="noticies-table__row__cell">
                    <a href="{{ route('hotel.editarNoticia', $noticia->id) }}" class="button button--edit">Editar</a>
                    <form action="{{ route('hotel.eliminarNoticia', $noticia->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button button--delete">Eliminar</button>
                    </form>
                    @if (!$noticia->publicada)
                        <form action="{{ route('hotel.publicarNoticia', $noticia->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="button button--publish">Publicar</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
