<?php

namespace Tests\Unit\Repayment;

use App\Actions\Loan\LoanApproveAction;
use App\Actions\Loan\LoanRepaidAction;
use App\Actions\Loan\LoanRequestAction;
use App\Actions\Repayment\RepaymentGenerateAction;
use App\Actions\Repayment\RepaymentPayAction;
use App\Models\Loan;
use App\Models\Repayment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoanRepaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_repayment_pay_action()
    {
        $adminUser = $this->adminUser();

        $user = $this->user();

        $this->actingAs($user);

        $loan = (new LoanRequestAction(new RepaymentGenerateAction()))->execute([
            'amount' => 100,
            'term' => 3,
        ]);

        $this->actingAs($adminUser);

        (new LoanApproveAction())->execute(Loan::query()->find($loan->id), [
            'notes' => 'Approved',
        ]);

        $this->actingAs($user);

        $repaymentAmount = 50;

        $repayment = (new RepaymentPayAction(new LoanRepaidAction))->execute($loan->repayments->first(), [
            'amount' => $repaymentAmount,
        ]);

        $this->assertEquals(round(100/3, 2), $repayment->amount);
        $this->assertEquals($repaymentAmount, $repayment->amount_paid);
        $this->assertEquals(Repayment::REPAYMENT_PAID, $repayment->status);
    }
}
