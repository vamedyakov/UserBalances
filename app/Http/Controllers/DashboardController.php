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

class DashboardController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function __invoke(Request $request): Response
    {
        $accounts = $request->user()->accounts()->orderBy('id', 'asc')->get();

        return Inertia::render('Dashboard', [
            "accounts" => $accounts
        ]);
    }
}
