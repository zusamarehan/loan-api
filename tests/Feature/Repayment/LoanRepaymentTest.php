<?php

namespace Tests\Feature\Repayment;

use App\Actions\Loan\LoanApproveAction;
use App\Actions\Loan\LoanRequestAction;
use App\Actions\Repayment\RepaymentGenerateAction;
use App\Models\Loan;
use App\Models\Repayment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoanRepaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_repayment_can_be_repaid()
    {
        $adminUser = $this->adminUser();

        $user = $this->user();

        $this->actingAs($user);

        $loan = (new LoanRequestAction(new RepaymentGenerateAction()))->execute([
            'amount' => 100,
            'term' => 3
        ]);

        $this->actingAs($adminUser);

        (new LoanApproveAction())->execute( Loan::query()->find($loan->id), [
            'notes' => 'Approved'
        ]);

        $this->actingAs($user);

        $repaymentAmount = 50;

        $response = $this->postJson(
            route('customer.repayment.repay', ['repayment' => $loan['repayments'][0]['id']]), [
                'amount' => $repaymentAmount
            ]
        );

        $response->assertOk();

        $response->assertJsonPath('status', Repayment::REPAYMENT_PAID);
        $response->assertJsonPath('amount_paid', $repaymentAmount);
    }

    public function test_a_repayment_cannot_be_repaid_if_payment_value_is_less_than_repayment_term()
    {
        $adminUser = $this->adminUser();

        $user = $this->user();

        $this->actingAs($user);

        $loan = (new LoanRequestAction(new RepaymentGenerateAction()))->execute([
            'amount' => 100,
            'term' => 3
        ]);

        $this->actingAs($adminUser);

        (new LoanApproveAction())->execute( Loan::query()->find($loan->id), [
            'notes' => 'Approved'
        ]);

        $this->actingAs($user);

        $repaymentAmount = 1;

        $response = $this->postJson(
            route('customer.repayment.repay', ['repayment' => $loan['repayments'][0]['id']]), [
                'amount' => $repaymentAmount
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_a_repayment_cannot_be_repaid_by_a_admin_user()
    {
        $adminUser = $this->adminUser();

        $user = $this->user();

        $this->actingAs($user);

        $loan = (new LoanRequestAction(new RepaymentGenerateAction()))->execute([
            'amount' => 100,
            'term' => 3
        ]);

        $this->actingAs($adminUser);

        (new LoanApproveAction())->execute( Loan::query()->find($loan->id), [
            'notes' => 'Approved'
        ]);

        $this->actingAs($adminUser);

        $repaymentAmount = 45;

        $response = $this->postJson(
            route('customer.repayment.repay', ['repayment' => $loan['repayments'][0]['id']]), [
                'amount' => $repaymentAmount
            ]
        );

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
