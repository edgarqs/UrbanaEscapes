<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Rol;
use App\Models\Usuari;

class RecepcioTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;


    public function test_recepcionista_can_access_home_page_expect_message()
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

        $this->get('/create')->assertOk();

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

        $response->assertRedirect('/hotel/home?id=1');

        $response = $this->followingRedirects()->get('/recepcio?id=1');

        $response->assertSeeText('Hotel Test');

        $response->assertOk();
    }
}
