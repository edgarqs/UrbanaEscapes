<?php

namespace Database\Seeders;

use App\Models\Rol;

class RolesSeeder extends DatabaseSeeder
{

    public function run(): void
    {

        // Creación de roles
        $roles = [
            ['nom' => 'administrador'],
            ['nom' => 'recepcionista'],
            ['nom' => 'client'],

        ];
        foreach ($roles as $rol) {
            Rol::create($rol);
        }
    }
}
