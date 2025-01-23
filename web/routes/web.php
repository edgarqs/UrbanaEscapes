<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'es', 'ca'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back(); // Redirige a la página actual
});
