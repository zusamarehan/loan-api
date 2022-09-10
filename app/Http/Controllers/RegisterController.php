<?php

namespace App\Http\Controllers;

use App\Actions\Auth\RegisterUserAction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    public function __invoke(RegisterUserAction $registerUserAction, Request $registerRequest): Response|Application|ResponseFactory
    {
        return response($registerUserAction->execute($registerRequest->all()));
    }
}
