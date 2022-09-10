<?php

namespace App\Actions\Repayment;

use App\Models\Loan;
use App\Models\Repayment;

class RepaymentGenerateAction
{
    public function execute(Loan $loan)
    {
        $repaymentAmount = $loan->amount / $loan->term;

        $repayment = [];

        for ($i = 0; $i < $loan->term; $i++) {
            $repayment[] = [
                'amount' => $repaymentAmount,
                'due_on' => now()->addWeeks($i + 1),
                'loan_id' => $loan->id,
                'updated_at' => now(),
                'created_at' => now(),
            ];
        }

        Repayment::insert($repayment);
    }
}
