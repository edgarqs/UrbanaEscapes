<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HotelTest extends TestCase
{
    public function test_when_create_hotel_expect_insert_hotel_in_database(): void
    {
        $response = $this->post('/create', [
            'nom' => 'Hotel Test',
            'adreca' => 'Carrer Test',
            'ciutat' => 'Ciutat Test',
            'pais' => 'Pais Test',
            'email' => 'test@test.es',
            'telefon' => '+34 123 45 67 89'
        ]);

        $response->assertStatus(302);
    }

    public function test_when_create_hotel_expect_redirect_to_selector_hotels(): void
    {
        $response = $this->post('/create', [
            'nom' => 'Hotel Test',
            'adreca' => 'Carrer Test',
            'ciutat' => 'Ciutat Test',
            'pais' => 'Pais Test',
            'email' => 'test@test.es',
            'telefon' => '+34 123 45 67 89'
        ]);

        $response->assertRedirect('/');
        $response->assertStatus(302);
    }
}
