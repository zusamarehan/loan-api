<?php

namespace Tests\Unit\Loan;

use App\Actions\Loan\LoanDeclineAction;
use App\Actions\Loan\LoanRequestAction;
use App\Actions\Repayment\RepaymentGenerateAction;
use App\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoanDeclineTest extends TestCase
{
    use RefreshDatabase;

    public function test_loan_decline_action()
    {
        $adminUser = $this->adminUser();

        $user = $this->user();

        $this->actingAs($user);

        $loan = (new LoanRequestAction(new RepaymentGenerateAction()))->execute([
            'amount' => 100,
            'term' => 3,
        ]);

        $this->actingAs($adminUser);

        $decline = (new LoanDeclineAction)->execute(Loan::query()->find($loan->id), [
            'notes' => "Decline",
        ]);

        $this->assertEquals(Loan::LOAN_DECLINE, $decline->status);
        $this->assertEquals($adminUser->id, $decline->handled_by_id);
    }
}
