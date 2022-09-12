<?php

namespace Tests\Feature\Loan;

use App\Actions\Loan\LoanApproveAction;
use App\Actions\Loan\LoanRequestAction;
use App\Actions\Repayment\RepaymentGenerateAction;
use App\Models\Loan;
use Database\Factories\LoanFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoanListTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_all_loans()
    {
        $adminUser = $this->adminUser();

        Loan::factory(10)->create();

        $this->actingAs($adminUser);

        $response = $this->getJson(
            route('admin.loan.list')
        );

        $response->assertJsonCount(10);
        $response->assertJsonStructure(['*' => ['id', 'user_id', 'amount', 'term']]);
        $response->assertOk();
    }

    public function test_it_cannot_list_all_loans_to_customers()
    {
        $user = $this->user();

        Loan::factory(10)->create();

        $this->actingAs($user);

        $this->getJson(
            route('admin.loan.list')
        )->assertUnauthorized();
    }

    public function test_it_can_filter_by_user_id()
    {
        $adminUser = $this->adminUser();
        $user = $this->user();

        Loan::factory(10)->create();
        Loan::factory(3)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($adminUser);

        $response = $this->getJson(
            route('admin.loan.list').'/?user_id='.$user->id
        );

        $response->assertJsonCount(3);
        $response->assertJsonStructure(['*' => ['id', 'user_id', 'amount', 'term']]);
        $response->assertOk();
    }

    public function test_it_can_filter_by_status()
    {
        $adminUser = $this->adminUser();

        Loan::factory(10)->create();
        Loan::factory(3)->create([
            'status' => Loan::LOAN_PAID
        ]);

        $this->actingAs($adminUser);

        $response = $this->getJson(
            route('admin.loan.list').'/?status='.Loan::LOAN_PAID
        );

        $response->assertJsonCount(3);
        $response->assertJsonStructure(['*' => ['id', 'user_id', 'amount', 'term']]);
        $response->assertOk();
    }
}
