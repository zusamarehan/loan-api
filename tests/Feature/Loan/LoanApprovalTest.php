<?php

namespace Tests\Feature\Loan;

use App\Actions\Loan\LoanApproveAction;
use App\Actions\Loan\LoanRequestAction;
use App\Actions\Repayment\RepaymentGenerateAction;
use App\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoanApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_admin_can_approve_a_loan_request()
    {
        $adminUser = $this->adminUser();

        $user = $this->user();

        $this->actingAs($user);

        $loan = (new LoanRequestAction(new RepaymentGenerateAction()))->execute([
            'amount' => 100,
            'term' => 3,
        ]);

        $this->actingAs($adminUser);

        $response = $this->postJson(
            route('admin.loan.approve', ['loan' => $loan->id]), ['notes' => 'Approved']
        );

        $response->assertOk();

        $response->assertJsonPath('handled_by_id', $adminUser->id);
        $response->assertJsonPath('user_id', $user->id);
    }

    public function test_a_user_cannot_approve_a_loan_request()
    {
        $anotherUser = $this->user();

        $user = $this->user();

        $this->actingAs($user);

        $loan = (new LoanRequestAction(new RepaymentGenerateAction()))->execute([
            'amount' => 100,
            'term' => 3,
        ]);

        $this->actingAs($anotherUser);

        $this->postJson(
            route('admin.loan.approve', ['loan' => $loan->id]), ['notes' => 'Approved']
        )->assertUnauthorized();
    }

    public function test_a_admin_cannot_approve_a_loan_which_is_already_approved()
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

        $response = $this->postJson(
            route('admin.loan.approve', ['loan' => $loan->id]), ['notes' => 'Approved']
        );

        $response->assertStatus(Response::HTTP_CONFLICT);
    }
}
