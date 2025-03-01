@extends('layouts.master')

@section('title', 'Notícies')

@section('content')
    <h1>Notícies</h1>

    <a href="{{ route('hotel.afegirNoticia') }}" class="button button--small"><span class="material-symbols-outlined">add</span>Afegir Notícia</a>
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
                    <div class="noticies-table__actions">
                        <a href="{{ route('hotel.editarNoticia', $noticia->id) }}" class="button button--icon button--edit">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <form action="{{ route('hotel.eliminarNoticia', $noticia->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="button button--icon button--delete">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </form>
                        @if (!$noticia->publicada)
                            <form action="{{ route('hotel.publicarNoticia', $noticia->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="button button--icon button--publish">
                                    <span class="material-symbols-outlined">publish</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
