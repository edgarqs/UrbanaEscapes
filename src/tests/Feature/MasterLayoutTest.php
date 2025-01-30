<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Rol;
use App\Models\Usuari;

class MasterLayoutTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;


    public function test_when_admin_accesses_home_page_expect_sidebar_button()
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
        $response = $this->get('/create');

        $response->assertDontSeeText('Recepció');
        $response->assertOk();
    }

    
}
