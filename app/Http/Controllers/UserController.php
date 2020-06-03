<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return "UserController@index";
    }

    public function pay_service_guest(Request $request)
    {
        $customMessages = [
            'required' => 'Нужно указать :attribute',
            'unique' => 'Такой адрес электронной почты уже существует',
        ];

        $request->validate([
            'full_name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'account_name' => 'required',
            'service_id' => 'required',
            // 'email' => 'required|email|unique:users',
            // 'password' => 'required|min:8',
        ], $customMessages);

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'account_name' => $request->account_name,
        ]);
        Auth::login($user, true);

        $order = Order::create([
            'user_id' => $user->id,
            'service_id' => $request->service_id,
            'paid_status' => 'pending'
        ]);

        return response()->json(['order_id' => $order->id]);
    }
}
