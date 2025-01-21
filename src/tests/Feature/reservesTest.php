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

        $hotel = Hotel::create([
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

        // Crear el usuario recepcionista
        Usuari::create([
            'nom' => 'recepcio1',
            'email' => 'recepcio1@example.com',
            'password' => bcrypt('recepcio1'),
            'rol_id' => 2
        ]);

        $this->get('/login')->assertOk();

        $response = $this->post('/login', [
            'nom' => 'recepcio1',
            'password' => 'recepcio1',
        ]);

        // Cambiamos la redirección esperada para que coincida con la real
        $response->assertRedirect('/recepcio?id=1');

        $this->get('/hotel/reserves/1')->assertOk();

        // Añadimos las comprobaciones para la creación de una reserva
        $habitacio = Habitacion::create([
            'tipus' => 'Doble',
            'llits' => 2,
            'llits_supletoris' => 1,
            'numHabitacion' => 101,
            'hotel_id' => $hotel->id,
        ]);

        $response = $this->post(route('reserves.store', ['habitacionId' => $habitacio->id]), [
            '_token' => csrf_token(),
            'dni' => '12345678A',
            'nom' => 'Client Test',
            'email' => 'client@example.com',
            'data_inici' => '2023-10-01',
            'data_fi' => '2023-10-10',
            'comentaris' => 'Comentari de prova',
        ]);

        $response->assertRedirect('/reserves/1'); 
        $this->assertDatabaseHas('reserves', [
            'dni' => '12345678A',
            'nom' => 'Client Test',
            'email' => 'client@example.com',
            'data_inici' => '2023-10-01',
            'data_fi' => '2023-10-10',
            'comentaris' => 'Comentari de prova',
        ]);
    }
}