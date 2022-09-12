<?php

namespace App\Http\Controllers\Loan;

use App\Http\Controllers\Controller;
use App\Queries\Loan\LoanListQuery;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class LoanListController extends Controller
{
    public function __invoke(LoanListQuery $loanListQuery): Response|Application|ResponseFactory
    {
        return response($loanListQuery->execute());
    }
}
