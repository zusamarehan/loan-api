<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginUserAction
{
    public function execute(array $data): array
    {
        validator($data, [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ])->validate();

        $user = User::query()->where('email', $data['email'])->first();

        if (! $user) {
            return [
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => 'User does not exists',
            ];
        }

        if (! $user && ! Hash::check($data['password'], $user->getAuthPassword())) {
            return [
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Credentials do not match',
            ];
        }

        return [
            'status' => Response::HTTP_OK,
            'token' => $user->createToken(time())->plainTextToken,
        ];
    }
}
