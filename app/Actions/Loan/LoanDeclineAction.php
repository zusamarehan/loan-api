<?php

namespace App\Actions\Loan;

use App\Http\Resources\Loan\LoanResource;
use App\Models\Loan;

class LoanDeclineAction
{
    public function execute(Loan $loan, array $data): LoanResource
    {
        validator($data, [
            'notes' => ['sometimes', 'string', 'max:255'],
        ])->validate();

        $loan->status = Loan::LOAN_DECLINE;
        $loan->notes = $data['notes'] ?? null;
        $loan->handled_by_id = auth()->user()->id;
        $loan->update();

        $loan->load(['user', 'handled_by']);

        return new LoanResource($loan);
    }
}
