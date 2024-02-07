<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Account;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class HistoryController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function __invoke(Request $request, int $accountId): Response
    {
        $account = $request->user()->accounts()->where('id', $accountId)->firstOrFail();

        return Inertia::render('History', [
            "account" => $account,
        ]);
    }
}
