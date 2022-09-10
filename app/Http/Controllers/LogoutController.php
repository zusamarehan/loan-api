<?php

namespace App\Http\Controllers;

use App\Actions\Auth\LogoutUserAction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class LogoutController extends Controller
{
    public function __invoke(LogoutUserAction $logoutUserAction): Response|Application|ResponseFactory
    {
        return response($logoutUserAction->execute());
    }
}
