<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

// Cambia al idioma solicitado
App::setLocale($locale);

// Verifica que el archivo del idioma existe
$path = resource_path("lang/{$locale}.json");
if (!file_exists($path)) {
    return response()->json(['error' => 'Language not found'], 404);
}

// Carga y devuelve el contenido JSON
return response()->json(json_decode(file_get_contents($path), true));