<?php

namespace App\Console\Commands;

use App\Jobs\PerformBalanceOperation;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;

class DepositFunds extends Command implements ShouldQueue
{
    protected $signature = 'balance:deposit {email} {amount} {description}';

    protected $description = 'Deposit funds to a user\'s balance';

    public function handle(): void
    {
        $user = User::where('email', $this->argument('email'))->firstOrFail();
        $account = $user->accounts()->where('is_default', true)->firstOrFail();

        dispatch(new PerformBalanceOperation($account, 'deposit', $this->argument('amount'), $this->argument('description')));

        $this->info('Balance operation added to the queue!');
    }
}
