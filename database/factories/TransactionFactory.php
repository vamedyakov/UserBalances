<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'description' => $this->faker->sentence,
            'amount' => $this->faker->randomFloat(2, 0, 1000),
            'type' => $this->faker->randomElement(['deposit', 'withdraw']),
        ];
    }
}
