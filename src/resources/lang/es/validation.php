<?php

return [
    // Reglas de validación
    'required' => 'El campo :attribute es obligatorio.',
    'string' => 'El campo :attribute debe ser una cadena de texto.',
    'max' => [
        'string' => 'El campo :attribute no puede tener más de :max caracteres.',
    ],
    'email' => 'El campo :attribute debe ser una dirección de correo electrónico válida.',
    'regex' => 'El campo :attribute no tiene un formato válido.',
    'email.required' => 'El correo electrónico es obligatorio.',
    'telefon.regex' => 'El número de teléfono introducido no tiene un formato válido.',
    'min' => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'confirmed' => 'La confirmación de :attribute no coincide.',
    'unique' => 'El campo :attribute ya está en uso.',
    'numeric' => 'El campo :attribute debe ser un número.',
    'date' => 'El campo :attribute debe ser una fecha válida.',
    'date_format' => 'El campo :attribute no coincide con el formato de fecha :format.',
    'mimes' => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'file' => 'El campo :attribute debe ser un archivo.',
    'url' => 'El campo :attribute no tiene un formato de URL válido.',
    'timezone' => 'El campo :attribute debe ser una zona horaria válida.',
    'after_or_equal' => 'El campo :attribute debe ser una fecha posterior o igual a :date.',

    // Nombres de los campos personalizados (formulario creación de hotel)
    'attributes' => [
        'nom' => 'nombre',
        'adreca' => 'dirección',
        'ciutat' => 'ciudad',
        'pais' => 'país',
        'email' => 'correo electrónico',
        'telefon' => 'teléfono',
    ],
];
