<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_is_disabled(): void
    {
        $response = $this->get('/register');

        $response->assertNotFound();
    }

    public function test_self_registration_is_disabled_on_the_server(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $response->assertNotFound();
        $this->assertDatabaseCount('users', 0);
    }

    public function test_email_verification_and_password_reset_endpoints_are_disabled(): void
    {
        foreach (['/forgot-password', '/reset-password/token', '/verify-email', '/verify-email/1/hash'] as $path) {
            $this->get($path)->assertNotFound();
        }

        foreach (['/forgot-password', '/reset-password', '/email/verification-notification'] as $path) {
            $this->post($path)->assertNotFound();
        }
    }
}
