<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\Repayment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class LoanFactory extends Factory
{
    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Loan $loan) {
            //
        })->afterCreating(function (Loan $loan) {
            for ($i = 0; $i <= $loan->term; $i++) {
                Repayment::factory(1)->create([
                    'loan_id' => $loan,
                    'amount' => $loan->amount / $loan->term,
                    'due_on' => now()->addWeeks($i + 1)
                ]);
            }
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'amount' => rand(100, 100000),
            'term' => rand(3, 8),
            'status' => Loan::LOAN_PENDING
        ];
    }
}
