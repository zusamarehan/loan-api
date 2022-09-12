<?php

namespace Tests\Unit\Loan;

use App\Actions\Loan\LoanRequestAction;
use App\Actions\Repayment\RepaymentGenerateAction;
use App\Models\Loan;
use App\Queries\Loan\LoanShowQuery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function Symfony\Component\Translation\t;

class LoanShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_loan_show_query()
    {
        $user = $this->user();

        $this->actingAs($user);

        $amount = 100;
        $term = 4;

        $loanRequest = (new LoanRequestAction(new RepaymentGenerateAction()))->execute([
            'amount' => $amount,
            'term' => $term,
        ]);

        $loan = (new LoanShowQuery)->execute(Loan::query()->find($loanRequest->id));

        $this->assertCount($term, $loan->repayments);
        $this->assertEquals($user->id, $loan->user_id);

    }
}
