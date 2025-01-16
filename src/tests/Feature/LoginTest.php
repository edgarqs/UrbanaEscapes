<?php

namespace Tests\Feature;

use App\Models\Rol;
use App\Models\Usuari;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_with_correct_credentials_expect_redirect()
    {
        Rol::create(['nom' => 'administrador']);

        Usuari::create([
            'nom' => 'admin',
            'email' => null,
            'password' => bcrypt('admin'),
            'rol_id' => 1
        ]);

        $this->assertDatabaseHas('usuaris', ['nom' => 'admin']);

        $this->get('/login')->assertOk();

        $response = $this->post('/login', [
            'nom' => 'admin',
            'password' => 'admin',
        ]);

        $response->assertRedirect('/');
    }

    public function test_user_with_nonexistent_account_cannot_login()
    {

        $this->get('/login')->assertOk();

        $response = $this->post('/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_recepcionista_can_login_with_correct_credentials_expect_redirect()
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

        $this->assertDatabaseHas('usuaris', ['nom' => 'recepcio1']);

        $this->get('/login')->assertOk();

        $response = $this->post('/login', [
            'nom' => 'recepcio1',
            'password' => 'recepcio1',
        ]);

        $response->assertRedirect('/recepcio?id=1');
    }
}
