@extends('layouts.master')

@section('title', 'Nou Hotel > Dades')

@section('content')

<div class="form card">
    <h3 class="center">Detalls del nou hotel</h3>
    <form action="{{ route('hotel.store') }}" method="post">
        @csrf
        <!-- Primera fila -->
        <div class="form-row d-flex">
            <div class="form-group flex-fill mr-3">
                <label for="clients">Clients</label>
                <input type="number" name="clients" id="clients" class="form-control @error('clients') is-invalid @enderror" value="{{ old('clients', 50) }}" min="0" placeholder="Quants clients vols crear per al hotel?" required>
                @error('clients')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Segunda fila -->
        <div class="form-row d-flex">
            <div class="form-group flex-fill">
                <label for="habitacions">Habitacions</label>
                <input type="number" name="habitacions" id="habitacions" class="form-control @error('habitacions') is-invalid @enderror" value="{{ old('habitacions', 100) }}" min="0" placeholder="Quantes habitacions vols crear?" required>
                @error('habitacions')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Tercera fila -->
        <div class="form-row d-flex">
            <div class="form-group flex-fill">
                <label for="reserves">Reserves</label>
                <input type="number" name="reserves" id="reserves" class="form-control @error('reserves') is-invalid @enderror" value="{{ old('reserves', 50) }}" min="0" placeholder="Quantes reserves vols crear?" required>
                @error('reserves')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="button button--primary button--margin-top">Crear dades</button>
    </form>
</div>
@endsection
