<?php

namespace App\Actions\Loan;

use App\Models\Loan;
use App\Models\Repayment;

class LoanRepaidAction
{
    public function execute(Loan $loan): bool
    {
        $loan->load(['repayments' => function ($repayments) {
            $repayments->where('status', Repayment::REPAYMENT_PENDING);
        }]);

        if (count($loan->repayments) > 0) {
            return false;
        }

        $loan->status = Loan::LOAN_PAID;
        $loan->update();

        return true;
    }
}
