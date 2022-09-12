<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_logout_successfully()
    {
        $user = $this->user();

        Sanctum::actingAs($user);

        $response = $this->postJson(route('auth.logout'));

        $response->assertStatus(200);
    }
}
