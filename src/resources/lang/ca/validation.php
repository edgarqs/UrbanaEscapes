<?php

return [
    'required' => 'El camp :attribute és obligatori.',
    'string' => 'El camp :attribute ha de ser una cadena de text.',
    'max' => [
        'string' => 'El camp :attribute no pot tenir més de :max caràcters.',
    ],
    'email' => 'El camp :attribute ha de ser una adreça de correu electrònic vàlida.',
    'regex' => 'El camp :attribute no té un format vàlid.',
    'email.required' => 'El correu electrònic és obligatori.',
    'telefon.regex' => 'El número de telèfon introduït no té un format vàlid.',
    'min' => [
        'string' => 'El camp :attribute ha de tenir almenys :min caràcters.',
    ],
    'confirmed' => 'La confirmació de :attribute no coincideix.',
    'unique' => 'El camp :attribute ja està en ús.',
    'numeric' => 'El camp :attribute ha de ser un nombre.',
    'date' => 'El camp :attribute ha de ser una data vàlida.',
    'date_format' => 'El camp :attribute no coincideix amb el format de data :format.',
    'mimes' => 'El camp :attribute ha de ser un arxiu de tipus: :values.',
    'file' => 'El camp :attribute ha de ser un fitxer.',
    'url' => 'El camp :attribute no té un format d\'URL vàlid.',
    'timezone' => 'El camp :attribute ha de ser una zona horària vàlida.',

    // Noms dels camps (formulari creació d'hotel)
    'attributes' => [
        'nom' => 'nom',
        'adreca' => 'adreça',
        'ciutat' => 'ciutat',
        'pais' => 'país',
        'email' => 'correu electrònic',
        'telefon' => 'telèfon',
    ],
];
