<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function adminUser()
    {
        return User::factory([
            'is_admin' => 1,
        ])->create();
    }

    public function user()
    {
        return User::factory()->create();
    }
}
