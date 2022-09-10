<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Http\Response;

class RegisterUserAction
{
    public function execute(array $data)
    {
        validator($data, [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed']
        ])->validate();

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->save();

        return [
            'status' => Response::HTTP_CREATED,
            'token' => $user->createToken('API Token')->plainTextToken
        ];
    }
}
