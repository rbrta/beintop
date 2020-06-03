<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use App\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $orders = Order::with(["service.category", "user"])->where("user_id", $user_id)->where("orders.paid_status", "active")->get();
        $user = auth()->user();
        $now = Carbon::now();

        $months = array(1 => 'Января', 2 => 'Февраля', 3 => 'Марта', 	4 => 'Апреля', 
        5 => 'Мая', 6 => 'Июня', 7 => 'Июля', 8 => 'Августа', 
        9 => 'Сентября', 10 => 'Октября', 11 => 'Ноября', 12 => 'Декабря');

        $orders->map(function ($item) use($now, $months){
            $item->expiration_date = Carbon::parse($item->expiration_date);
            $item->days = $item->expiration_date->diffInDays($now);
            $item->month = $months[(int)$item->expiration_date->format('m')];
            return $item;
        });

        return view("client", compact("orders", "user")); 
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
