<?php

namespace App\Listeners;

use App\Events\AccountUpdated;
use App\Models\Account;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateDefaultAccount
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
    public function handle(AccountUpdated $event): void
    {
        if ($event->account->is_default) {
            Account::where('id', '!=', $event->account->id)
                ->where('user_id', $event->account->user_id)
                ->where('is_default', true)
                ->update(['is_default' => false]);
        }
    }
}
