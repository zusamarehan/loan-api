<?php

namespace Tests\Unit\Loan;

use App\Actions\Loan\LoanApproveAction;
use App\Actions\Loan\LoanDeclineAction;
use App\Actions\Loan\LoanRequestAction;
use App\Actions\Repayment\RepaymentGenerateAction;
use App\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoanApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_loan_approval_action()
    {
        $adminUser = $this->adminUser();

        $user = $this->user();

        $this->actingAs($user);

        $loan = (new LoanRequestAction(new RepaymentGenerateAction()))->execute([
            'amount' => 100,
            'term' => 3,
        ]);

        $this->actingAs($adminUser);

        $approved = (new LoanApproveAction())->execute(Loan::query()->find($loan->id), [
            'notes' => "Approved",
        ]);

        $this->assertEquals(Loan::LOAN_APPROVED, $approved->status);
        $this->assertEquals($adminUser->id, $approved->handled_by_id);
    }
}
