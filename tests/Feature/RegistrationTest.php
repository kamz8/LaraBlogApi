<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function registrationTest(): void
    {
        $response = $this->json('POST', '/api/register', [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(201);
    }
}
