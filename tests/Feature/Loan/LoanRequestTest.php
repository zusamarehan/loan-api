<?php

namespace Tests\Feature\Loan;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_loan_request_can_be_created_with_correct_inputs()
    {
        $user = $this->user();

        $this->actingAs($user);

        $amount = 100;
        $term = 4;

        $response = $this->postJson(route('customer.loan.request'), [
            'amount' => $amount,
            'term' => $term,
        ]);

        $response->assertOk();

        $response->assertJsonPath('amount', $amount);
        $response->assertJsonPath('term', $term);
        $response->assertJsonCount($term, 'repayments');
        $response->assertJsonPath('user_id', $user->id);
    }

    public function test_a_loan_request_cannot_be_created_with_incorrect_amount()
    {
        $user = $this->user();

        $this->actingAs($user);

        $amount = 'one hundred';
        $term = 4;

        $response = $this->postJson(route('customer.loan.request'), [
            'amount' => $amount,
            'term' => $term,
        ]);

        $this->assertArrayHasKey('errors', $response);
        $this->assertArrayHasKey('amount', $response['errors']);

        $response->assertStatus(422);
    }

    public function test_a_loan_request_cannot_be_created_with_incorrect_term()
    {
        $user = $this->user();

        $this->actingAs($user);

        $amount = 100;
        $term = '5 term';

        $response = $this->postJson(route('customer.loan.request'), [
            'amount' => $amount,
            'term' => $term,
        ]);

        $this->assertArrayHasKey('errors', $response);
        $this->assertArrayHasKey('term', $response['errors']);

        $response->assertStatus(422);
    }

    public function test_a_loan_cannot_be_requested_by_a_admin_user()
    {
        $user = $this->adminUser();

        $this->actingAs($user);

        $amount = 100;
        $term = '5';

        $this->postJson(route('customer.loan.request'), [
            'amount' => $amount,
            'term' => $term,
        ])->assertUnauthorized();
    }
}
