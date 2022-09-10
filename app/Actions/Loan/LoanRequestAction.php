<?php

namespace App\Actions\Loan;

use App\Http\Resources\Loan\LoanRequestResource;
use App\Models\Loan;

class LoanRequestAction
{
    public function execute(array $data): LoanRequestResource
    {
        validator($data, [
            'amount' => ['required', 'numeric', 'gte:1'],
            'term' => ['required', 'integer', 'numeric', 'gte:1'],
        ])->validate();

        $loan = new Loan();
        $loan->user_id = auth()->user()->id;
        $loan->amount = round($data['amount'], 2);
        $loan->term = (int) $data['term'];
        $loan->status = Loan::APPROVAL_PENDING;
        $loan->save();

        return new LoanRequestResource($loan);
    }
}
