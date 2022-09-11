<?php

namespace App\Http\Controllers;

use App\Actions\Loan\LoanDeclineAction;
use App\Models\Loan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoanDeclineController extends Controller
{
    public function __invoke(Loan $loan, LoanDeclineAction $loanDeclineAction, Request $loanDeclineRequest): Response|Application|ResponseFactory
    {
        if ($loan->status === Loan::LOAN_APPROVED) {
            return response([
                'message' => 'Approved loan cannot be declined',
            ], Response::HTTP_CONFLICT);
        }

        if ($loan->status === Loan::LOAN_DECLINE) {
            return response([
                'message' => 'Loan has been already been declined',
            ], Response::HTTP_CONFLICT);
        }

        return response($loanDeclineAction->execute($loan, $loanDeclineRequest->all()));
    }
}
