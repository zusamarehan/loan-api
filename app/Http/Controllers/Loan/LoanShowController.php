<?php

namespace App\Http\Controllers\Loan;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Queries\Loan\LoanShowQuery;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class LoanShowController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(Loan $loan, LoanShowQuery $loanShowQuery): Response|Application|ResponseFactory
    {
        $this->authorize('show', $loan);

        return response($loanShowQuery->execute($loan));
    }
}
