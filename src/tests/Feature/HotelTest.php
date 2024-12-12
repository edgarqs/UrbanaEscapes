<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HotelTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_when_create_hotel_expect_redirect_to_selector_hotels(): void
    {
        $response=$this->get('/create');
        $response->assertRedirectToRoute('/');
        $response->assertOk();
    }
}
