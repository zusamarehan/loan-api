<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\Repayment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class RepaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'loan_id' => Loan::factory(),
            'amount' => rand(100, 100000),
            'amount_paid' => null,
            'due_on' => now()->addWeek(),
            'paid_on' => null,
            'status' => Repayment::REPAYMENT_PENDING,
        ];
    }
}
