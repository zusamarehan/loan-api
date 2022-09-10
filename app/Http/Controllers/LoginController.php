<?php

namespace App\Http\Controllers;

use App\Actions\Auth\LoginUserAction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function __invoke(LoginUserAction $loginUserAction, Request $loginRequest) : Response|Application|ResponseFactory
    {
        return response($loginUserAction->execute($loginRequest->all()));
    }
}
