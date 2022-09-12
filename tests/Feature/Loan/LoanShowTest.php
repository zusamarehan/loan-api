<?php

namespace Tests\Feature\Loan;

use App\Actions\Loan\LoanApproveAction;
use App\Actions\Loan\LoanRequestAction;
use App\Actions\Repayment\RepaymentGenerateAction;
use App\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoanShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_show_the_requested_loan()
    {
        $user = $this->user();

        $this->actingAs($user);

        $amount = 100;
        $term = 4;

        $loan = (new LoanRequestAction(new RepaymentGenerateAction()))->execute([
            'amount' => $amount,
            'term' => $term,
        ]);

        $response = $this->getJson(
            route('loan.show', ['loan' => $loan->id])
        );

        $response->assertOk();

        $response->assertJsonCount($term, 'repayments');
        $response->assertJsonPath('user_id', $user->id);
    }

    public function test_it_cannot_show_the_requested_loan_created_by_other_users()
    {
        $user = $this->user();
        $anotherUser = $this->user();

        $this->actingAs($user);

        $amount = 100;
        $term = 4;

        $loan = (new LoanRequestAction(new RepaymentGenerateAction()))->execute([
            'amount' => $amount,
            'term' => $term,
        ]);

        $this->actingAs($anotherUser);

        $response = $this->getJson(
            route('loan.show', ['loan' => $loan->id])
        );

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_it_can_show_the_requested_loan_to_admin_created_by_other_users()
    {
        $user = $this->user();
        $adminUser = $this->adminUser();

        $this->actingAs($user);

        $amount = 100;
        $term = 4;

        $loan = (new LoanRequestAction(new RepaymentGenerateAction()))->execute([
            'amount' => $amount,
            'term' => $term,
        ]);

        $this->actingAs($adminUser);

        $response = $this->getJson(
            route('loan.show', ['loan' => $loan->id])
        );

        $response->assertOk();

        $response->assertJsonCount($term, 'repayments');
        $response->assertJsonPath('user_id', $user->id);
    }
}
