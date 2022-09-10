<?php

namespace App\Http\Controllers;

use App\Actions\Loan\LoanRequestAction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoanRequestController extends Controller
{
    public function __invoke(LoanRequestAction $loanRequestAction, Request $loanRequest): Response|Application|ResponseFactory
    {
        return response($loanRequestAction->execute($loanRequest->all()));
    }
}
