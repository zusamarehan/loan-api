<?php

namespace App\Http\Controllers\Repayment;

use App\Actions\Repayment\RepaymentPayAction;
use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Repayment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RepaymentPayController extends Controller
{
    public function __invoke(Repayment $repayment, RepaymentPayAction $repaymentPayAction, Request $repaymentRequest): Response|Application|ResponseFactory
    {
        $this->authorize('repay', $repayment);

        $repayment->load(['loan']);

        if ($repayment->loan->status !== Loan::LOAN_APPROVED) {
            return response([
                'message' => 'Loan has not been approved, yet!',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($repayment->status === Repayment::REPAYMENT_PAID) {
            return response([
                'message' => 'Current term has been paid already!',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $action = $repaymentPayAction->execute($repayment, $repaymentRequest->all());

        if (is_array($action)) {
            return response($action, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response($repaymentPayAction->execute($repayment, $repaymentRequest->all()));
    }
}
