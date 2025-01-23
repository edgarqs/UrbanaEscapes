<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Rol;
use App\Models\Usuari;
use App\Models\Hotel;
use App\Models\Habitacion;

class reservesTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_recepcio_create_reserva(): void
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

        $this->post('/logout');

        $response = $this->post('/login', [
            'nom' => 'recepcio1',
            'password' => 'recepcio1',
        ]);

        $this->get('/hotel/recepcio?id=1')->assertOk();
        $this->get('/hotel/reserves/1')->assertOk();

        $response = $this->post('/hotel/reserves/1', [
            'data_entrada' => '2021-06-01',
            'data_sortida' => '2021-06-05',
            'dni' => '12345678A',
            'nom' => 'Test',
            'comentaris' => 'Comentari de prova per a la reserva.',
        ]);        
    }

    public function test_reserva_error_dates(): void
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

        $this->post('/logout');

        $response = $this->post('/login', [
            'nom' => 'recepcio1',
            'password' => 'recepcio1',
        ]);

        $this->get('/hotel/recepcio?id=1')->assertOk();
        $this->get('/hotel/reserves/1')->assertOk();

        $response = $this->post('/hotel/reserves/1', [
            'data_entrada' => '2021-06-01',
            'data_sortida' => '2020-06-05',
            'dni' => '12345678A',
            'nom' => 'Test',
            'comentaris' => 'Comentari de prova per a la reserva.',
        ]);        

        $response->assertSeeText('El camp data fi ha de ser una data posterior o igual a data inici.');
    }
}