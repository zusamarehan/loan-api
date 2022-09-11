<?php

namespace App\Actions\Loan;

use App\Actions\Repayment\RepaymentGenerateAction;
use App\Http\Resources\Loan\LoanResource;
use App\Models\Loan;

class LoanRequestAction
{
    protected $repayments;

    public function __construct(RepaymentGenerateAction $repaymentGenerateAction)
    {
        $this->repayments = $repaymentGenerateAction;
    }

    public function execute(array $data): LoanResource
    {
        validator($data, [
            'amount' => ['required', 'numeric', 'gte:1'],
            'term' => ['required', 'integer', 'numeric', 'gte:1'],
        ])->validate();

        $loan = new Loan();
        $loan->user_id = auth()->user()->id;
        $loan->amount = round($data['amount'], 2);
        $loan->term = (int) $data['term'];
        $loan->status = Loan::LOAN_PENDING;
        $loan->save();

        $this->repayments->execute($loan);
        $loan->load(['repayments']);

        return new LoanResource($loan);
    }
}
