<?php

namespace Database\Seeders;

use App\Models\Rol;

use Illuminate\Support\Facades\Log;

class RolesSeeder extends DatabaseSeeder
{

    public function run(): void
    {

        // Creación de roles
        $roles = [
            ['nom' => 'administrador'],
            ['nom' => 'recepcionista']
        ];
        foreach ($roles as $rol) {
            Rol::create($rol);
        }
    }
}
