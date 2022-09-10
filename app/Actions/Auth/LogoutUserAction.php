<?php

namespace App\Actions\Auth;

use Illuminate\Http\Response;

class LogoutUserAction
{
    public function execute(): array
    {
        auth()->user()->currentAccessToken()->delete();

        return [
            'status' => Response::HTTP_OK,
        ];
    }
}
