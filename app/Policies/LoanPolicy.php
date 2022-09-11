<?php

namespace App\Policies;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LoanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  User  $user
     * @param  Loan  $loan
     * @return bool
     */
    public function show(User $user, Loan $loan)
    {
        return ($user->id === $loan->user_id) || $user->isAdmin();
    }
}
