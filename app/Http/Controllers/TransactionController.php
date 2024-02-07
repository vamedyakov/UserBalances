<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

class TransactionController extends Controller
{
    public function index(Request $request, int $accountId)
    {
        $limit = $request->input('limit', 5);
        $offset = $request->input('offset', 0);
        $query = $request->input('query', '');
        $orderBy = $request->input('order_by', 'created_at');
        $direction = $request->input('direction', 'asc');
        $account = $request->user()->accounts()->where('id', $accountId)->firstOrFail();

        if($limit > 100) {
            $limit = 100;
        }

        return [
            "transactions" => $account->transactions()
                ->where('description', 'like', "%$query%")
                ->orderBy($orderBy, $direction)
                ->limit($limit)
                ->offset($offset)
                ->get(),
            "total" => $account->transactions()->where('description', 'like', "%$query%")->count()
        ];
    }
}
