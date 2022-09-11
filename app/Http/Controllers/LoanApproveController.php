<?php

namespace App\Http\Controllers;

use App\Actions\Loan\LoanApproveAction;
use App\Models\Loan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoanApproveController extends Controller
{
    public function __invoke(Loan $loan, LoanApproveAction $loanApprovalAction, Request $loanApprovalRequest): Response|Application|ResponseFactory
    {
        if ($loan->status === Loan::LOAN_APPROVED) {
            return response([
                'message' => 'Loan has been already been approved',
            ], Response::HTTP_CONFLICT);
        }

        return response($loanApprovalAction->execute($loan, $loanApprovalRequest->all()));
    }
}
