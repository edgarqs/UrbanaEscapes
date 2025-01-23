<?php

namespace Tests;

use App\Models\Rol;
use App\Models\Hotel;
use App\Models\Usuari;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    use RefreshDatabase;
    protected function admin(): Usuari
    {
        Rol::create(['nom' => 'administrador','id' => 1]);
        Rol::create(['nom' => 'recepcionista','id' => 2]);

        $admin = Usuari::create([
            'nom' => 'admin',
            'password' => bcrypt('admin'),
            'rol_id' => 1
        ]);

        return $admin;
    }
}