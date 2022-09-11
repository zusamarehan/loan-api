<?php

namespace App\Queries\Loan;

use App\Http\Resources\Loan\LoanResource;
use App\Models\Loan;

class LoanShowQuery
{
    public function execute(Loan $loan)
    {
        $loan->load(['repayments', 'user', 'handled_by']);

        return new LoanResource($loan);
    }
}
