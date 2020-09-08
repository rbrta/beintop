<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Account;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ManagerController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function clients(): JsonResponse
    {
        $accounts = Account::whereHas('user', function($q) {
            $q->where('manager', auth()->user()->id);
        })->get();

        $accounts = $accounts->sortBy('latest_order.expiration_date')->values();

        return response()->json($accounts);
    }

    public function addClient(Request $request)
    {
        $user = User::create([
            'phone' => $request->phone,
            'manager' => auth()->user()->id,
            'login_code' => User::generateLoginCode(),
            'full_name' => $request->filled('full_name') ? $request->full_name : '',
        ]);

        Account::create([
            'account_name' => $request->account,
            'user_id' => $user->id
        ]);

        return $user;

    }
}
