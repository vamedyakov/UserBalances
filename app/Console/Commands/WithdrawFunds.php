<?php

namespace App\Console\Commands;

use App\Jobs\PerformBalanceOperation;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\User;
use Illuminate\Console\Command;

class WithdrawFunds extends Command
{
    protected $signature = 'balance:withdraw {email} {amount} {description}';

    protected $description = 'Withdraw funds from a user\'s balance';

    public function handle(): void
    {
        $user = User::where('email', $this->argument('email'))->firstOrFail();
        $account = $user->accounts()->where('is_default', true)->firstOrFail();
        $amount = $this->argument('amount');

        // Проверить, не приведет ли операция к отрицательному балансу
        $newBalance = $account->balance - $amount;

        if ($newBalance < 0) {
            $this->error('Insufficient balance!');
            return;
        }

        dispatch(new PerformBalanceOperation($account, 'withdraw', -$amount, $this->argument('description')));

        $this->info('Balance operation added to the queue!');
    }
}
