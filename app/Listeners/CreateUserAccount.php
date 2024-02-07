<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Account;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateUserAccount
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        Account::create([
            'user_id' => $event->user->id,
            'balance' => 0,
            'is_default' => true,
            'name' => 'Main account',
        ]);
    }
}
