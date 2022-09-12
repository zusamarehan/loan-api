<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_login_successfully()
    {
        $user = $this->user();

        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertArrayHasKey('token', $response);
        $response->assertStatus(200);
    }

    public function test_a_user_cannot_login_with_incorrect_password()
    {
        $user = $this->user();

        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $this->assertArrayNotHasKey('token', $response);
        $response->assertStatus(200);
    }

    public function test_a_user_cannot_login_with_incorrect_user()
    {
        $response = $this->postJson(route('auth.login'), [
            'email' => 'rehan@aspire.app',
            'password' => 'secret',
        ]);

        $this->assertArrayNotHasKey('token', $response);
        $response->assertStatus(200);
    }
}
