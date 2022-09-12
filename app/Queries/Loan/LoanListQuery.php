<?php

namespace App\Queries\Loan;

use App\Http\Resources\Loan\LoanResource;
use App\Models\Loan;

class LoanListQuery
{
    public function execute()
    {
        $loans = Loan::query()
            ->with(['user', 'repayments', 'handled_by'])
            ->when(request('user_id'), function ($user) {
                $user->where('user_id', request('user_id'));
            })
            ->when(request('status'), function ($user) {
                $user->where('status', request('status'));
            })
            ->when(request('handled_by_id'), function ($user) {
                $user->where('handled_by_id', request('handled_by_id'));
            })
            ->latest('id')
            ->get();

        return LoanResource::collection($loans);
    }
}
