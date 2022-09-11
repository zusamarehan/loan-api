<?php

namespace App\Http\Controllers\Loan;

use App\Actions\Loan\LoanApproveAction;
use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function response;

class LoanApproveController extends Controller
{
    public function __invoke(Loan $loan, LoanApproveAction $loanApprovalAction, Request $loanApprovalRequest): Response|Application|ResponseFactory
    {
        if ($loan->status === Loan::LOAN_DECLINE) {
            return response([
                'message' => 'Declined loan cannot be approved',
            ], Response::HTTP_CONFLICT);
        }

        if ($loan->status === Loan::LOAN_APPROVED) {
            return response([
                'message' => 'Loan has been already been approved',
            ], Response::HTTP_CONFLICT);
        }

        return response($loanApprovalAction->execute($loan, $loanApprovalRequest->all()));
    }
}
