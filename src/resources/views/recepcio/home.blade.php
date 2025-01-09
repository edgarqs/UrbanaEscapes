@extends('layouts.master')

@section('title', 'Recepció')

@section('content')
    <meta hidden name="hotel-id" content="{{ $hotel->id }}">
    <h1 class="hotel-title">{{ $hotel->nom }}</h1>
    <div class="calendar-navigation">
        <button class="button-calendar" id="prevWeek">← 7 días atrás</button>
        <button class="button-calendar" id="nextWeek">7 días adelante →</button>
    </div>
    <table id="weekCalendar">
        <thead>
            <tr id="headerRow">
                <!-- Aquí se llenarán las cabeceras -->
            </tr>
        </thead>
        <tbody id="calendarBody">
            <!-- Aquí se llenarán las filas del calendario -->
        </tbody>
    </table>
    <script src="{{ asset('js/calendar.js') }}"></script>
@endsection

