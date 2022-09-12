<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_register_with_valid_email()
    {
        $response = $this->postJson(route('auth.register'), [
            'name' => 'rehan',
            'email' => 'rehan@aspire.app',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $this->assertArrayHasKey('token', $response);
        $response->assertStatus(200);
    }

    public function test_a_user_cannot_register_with_invalid_email()
    {
        $response = $this->postJson(route('auth.register'), [
            'name' => 'rehan',
            'email' => 'rehan',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $this->assertArrayHasKey('errors', $response);
        $this->assertArrayHasKey('email', $response['errors']);
        $this->assertArrayNotHasKey('token', $response);
        $response->assertStatus(422);
    }

    public function test_a_user_cannot_register_with_incorrect_password_confirmation()
    {
        $response = $this->postJson(route('auth.register'), [
            'name' => 'rehan',
            'email' => 'rehan',
            'password' => 'secret',
            'password_confirmation' => 'rehan',
        ]);

        $this->assertArrayHasKey('errors', $response);
        $this->assertArrayHasKey('password', $response['errors']);
        $this->assertArrayNotHasKey('token', $response);
        $response->assertStatus(422);
    }

    public function test_a_user_cannot_register_without_name()
    {
        $response = $this->postJson(route('auth.register'), [
            'email' => 'rehan@aspire.app',
            'password' => 'secret',
            'password_confirmation' => 'rehan',
        ]);

        $this->assertArrayHasKey('errors', $response);
        $this->assertArrayHasKey('name', $response['errors']);
        $this->assertArrayNotHasKey('token', $response);
        $response->assertStatus(422);
    }
}
