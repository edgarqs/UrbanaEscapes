@extends('layouts.master')

@section('content')
    <div class="home">
        
        <div class="cards">
            <div class="item">
                <h1>Habitacions ocupades</h1>
                
            </div>
            <div class="item">
                <h1>Habitacions lliures</h1>
                
            </div>
            <div class="item">
                <h1>Habitacions reservades</h1>
                    
            </div>
        </div>

        <div class="habitacions">
            <div class="habitacions-list">
                <table>
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Tipus</th>
                            <th>Preu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($habitacions as $habitacio)
                            <tr>
                                <td>{{ $habitacio->numero }}</td>
                                <td>{{ $habitacio->tipus }}</td>
                                <td>{{ $habitacio->preu }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection