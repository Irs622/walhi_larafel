<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_is_disabled_and_returns_404(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(404);
    }
}
