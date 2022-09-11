<?php

namespace App\Policies;

use App\Models\Repayment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RepaymentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given repayment can be paid by the user.
     *
     * @param  User  $user
     * @param  Repayment  $repayment
     * @return bool
     */
    public function repay(User $user, Repayment $repayment): bool
    {
        $repayment->load(['loan:id,user_id']);

        return $user->id === $repayment->loan->user_id;
    }
}
