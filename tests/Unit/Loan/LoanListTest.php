<?php

namespace Tests\Unit\Loan;

use App\Models\Loan;
use App\Queries\Loan\LoanListQuery;
use App\Queries\Loan\LoanShowQuery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanListTest extends TestCase
{
    use RefreshDatabase;

    public function test_loan_list_query()
    {
        $adminUser = $this->adminUser();

        Loan::factory(10)->create();

        $this->actingAs($adminUser);

        (new LoanListQuery())->execute();

        $this->assertDatabaseCount('loans', 10);
    }
}
