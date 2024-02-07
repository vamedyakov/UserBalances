<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Transaction;
use App\Models\Account;

class PerformBalanceOperation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Account $account;
    protected $type;
    protected int $amount;
    protected String $description;

    public function __construct(Account $account, $type, $amount, $description)
    {
        $this->account = $account;
        $this->amount = intval($amount);
        $this->description = $description;
        $this->type = $type;
    }

    public function handle()
    {
        Transaction::create([
            'account_id' => $this->account->id,
            'amount' => abs($this->amount),
            'type' => $this->type,
            'description' => $this->description,
        ]);

        $this->account->balance += $this->amount;
        $this->account->save();
    }
}
