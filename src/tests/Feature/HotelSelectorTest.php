<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Rol;
use App\Models\Usuari;
use Tests\TestCase;

class HotelSelectorTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_admin_can_select_hotel()
    {

        $response = $this->actingAs($this->admin())->get('/create');

        $response->assertOk();

        $response = $this->actingAs($this->admin())->post('/create', [
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

        $response = $this->actingAs($this->admin())->get('/');
        $response->assertOk();

        $response->assertSeeText('Hotel Test');



    }
}