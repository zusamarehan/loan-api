<?php

namespace Tests\Unit\Loan;

use App\Actions\Loan\LoanRequestAction;
use App\Actions\Repayment\RepaymentGenerateAction;
use App\Models\Loan;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class LoanRequestTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_loan_request_action()
    {
        $user = $this->user();

        $this->actingAs($user);

        $amount = 100;
        $term = 4;

       $loan = (new LoanRequestAction(new RepaymentGenerateAction()))->execute([
           'amount' => $amount,
           'term' => $term
       ]);

       $this->assertEquals($amount, $loan->amount);
       $this->assertEquals($term, $loan->term);
       $this->assertCount($term, $loan->repayments);
       $this->assertEquals($user->id, $loan->user_id);
    }
}
