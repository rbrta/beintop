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
    public function clients(Request $request)
    {
        return User::with('orders')->get(); //temp
        // return auth()->user()->getClients();
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
