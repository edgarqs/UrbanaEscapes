@extends('layouts.master')

@section('title', 'Hotels')

@section('content')
    <div class="index">
        <a href="{{ route('hotel.create') }}" class="btn btn-primary">Crea Hotel</a>
    </div>
    <div class="hotels">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Adreça</th>
                    <th>Ciutat</th>
                    <th>Pais</th>
                    <th>Email</th>
                    <th>Telèfon</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hotels as $hotel)
                    <tr>
                        <td>{{ $hotel->nom }}</td>
                        <td>{{ $hotel->adreca }}</td>
                        <td>{{ $hotel->ciutat }}</td>
                        <td>{{ $hotel->pais }}</td>
                        <td>{{ $hotel->email }}</td>
                        <td>{{ $hotel->telefon }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
