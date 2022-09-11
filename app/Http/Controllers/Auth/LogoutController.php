<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LogoutUserAction;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use function response;

class LogoutController extends Controller
{
    public function __invoke(LogoutUserAction $logoutUserAction): Response|Application|ResponseFactory
    {
        return response($logoutUserAction->execute());
    }
}
