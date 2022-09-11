<?php

namespace App\Actions\Repayment;

use App\Actions\Loan\LoanRepaidAction;
use App\Http\Resources\Repayment\RepaymentResource;
use App\Models\Repayment;

class RepaymentPayAction
{
    protected $loanRepaidAction;

    public function __construct(LoanRepaidAction $loanRepaidAction)
    {
        $this->loanRepaidAction = $loanRepaidAction;
    }

    public function execute(Repayment $repayment, array $data): array|RepaymentResource
    {
        validator($data, [
            'amount' => ['required', 'gte:1', 'numeric']
        ])->validate();

        if ($data['amount'] < $repayment->amount) {
            return [
                "message" => "The amount ({$data['amount']}) should be greater or equal to Repayment value ({$repayment->amount})"
            ];
        }

        $repayment->status = Repayment::REPAYMENT_PAID;
        $repayment->amount_paid = round($data['amount'], 2);
        $repayment->paid_on = now();
        $repayment->update();

        $this->loanRepaidAction->execute($repayment->loan);

        return new RepaymentResource($repayment);
    }
}
