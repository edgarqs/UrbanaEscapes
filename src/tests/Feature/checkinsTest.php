<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Rol;
use App\Models\Usuari;
use App\Models\Hotel;

class checkinsTest extends TestCase
{
    use RefreshDatabase;

    public function test_recepcio_can_search_by_date(): void
    {
        Rol::create(['nom' => 'administrador']);
        Rol::create(['nom' => 'recepcionista']);
        Rol::create(['nom' => 'client']);

        Usuari::create([
            'nom' => 'admin',
            'email' => null,
            'password' => bcrypt('admin'),
            'rol_id' => 1
        ]);

        $this->get('/login')->assertOk();

        $response = $this->post('/login', [
            'nom' => 'admin',
            'password' => 'admin',
        ]);

        $response->assertRedirect('/');

        $response = $this->post('/create', [
            'nom' => 'Hotel Test',
            'adreca' => 'Carrer Test, 1',
            'ciutat' => 'Test',
            'pais' => 'Test',
            'email' => 'test@example.es',
            'telefon' => '123456789',
            'clients' => 50,
            'habitacions' => 100,
            'reserves' => 50,
        ]); 

        $this->get('/login')->assertOk();

        $response = $this->post('/login', [
            'nom' => 'recepcio1',
            'password' => 'recepcio1',
        ]);

        $response->assertRedirect('/recepcio?id=1');

        $this->get('/hotel/recepcio?id=1')->assertOk();
        $this->get('/hotel/checkins?id=1')->assertOk();

        
        $response = $this->get('/hotel/checkins', [
            'data_sortida' => '2025-06-02',
        ]);

    }

    public function test_recepcio_can_search_by_date_error(): void
    {
        Rol::create(['nom' => 'administrador']);
        Rol::create(['nom' => 'recepcionista']);
        Rol::create(['nom' => 'client']);

        Usuari::create([
            'nom' => 'admin',
            'email' => null,
            'password' => bcrypt('admin'),
            'rol_id' => 1
        ]);

        $this->get('/login')->assertOk();

        $response = $this->post('/login', [
            'nom' => 'admin',
            'password' => 'admin',
        ]);

        $response->assertRedirect('/');

        $response = $this->post('/create', [
            'nom' => 'Hotel Test',
            'adreca' => 'Carrer Test, 1',
            'ciutat' => 'Test',
            'pais' => 'Test',
            'email' => 'test@example.es',
            'telefon' => '123456789',
            'clients' => 50,
            'habitacions' => 100,
            'reserves' => 50,
        ]); 

        $this->get('/login')->assertOk();

        $response = $this->post('/login', [
            'nom' => 'recepcio1',
            'password' => 'recepcio1',
        ]);

        $response->assertRedirect('/recepcio?id=1');

        $this->get('/hotel/recepcio?id=1')->assertOk();
        $this->get('/hotel/checkins?id=1')->assertOk();

        
        $response = $this->get('/hotel/checkins', [
            'data_sortida' => '2025-06-02',
        ]);

    }
}