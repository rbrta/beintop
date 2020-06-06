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

        Carbon::setlocale('ru');
        $orders->map(function ($item) use ($now) {
            $item->expiration_date = Carbon::parse($item->expiration_date);
            $item->days = $item->expiration_date->diffInDays($now);
            $item->expiration_date_format = $item->expiration_date->translatedFormat("d F Y");
            return $item;
        });

        return view("client", compact("orders", "user"));
    }

    public function new_order()
    {
        $services = Service::with("category")->get();
        $user = auth()->user();
        return view("new_order", compact("services", "user"));
    }

    public function add_new_order(Request $request)
    {
        $order = Order::create([
            'user_id' => $request->user_id,
            'service_id' => $request->service_id,
            'paid_status' => 'pending'
        ]);

        return response()->json(['order_id' => $order->id]);
    }

    public function pay_service_guest(Request $request)
    {
        $customMessages = [
            'full_name.required' => 'Необходимо заполнить поле "Полное имя"',
            'email.required' => 'Необходимо заполнить поле "Email"',
            'password.required' => 'Не указан "Пароль"',
            'account_name.required' => 'Не указано "Имя профиля Instagram"',
            'service_id.required' => 'Не указан "Тариф"',
            'unique' => 'Такой адрес электронной почты уже существует',
        ];

        $request->validate([
            'full_name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'account_name' => 'required',
            'service_id' => 'required',

        ], $customMessages);

        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user, true);

        $service = Service::find($request->service_id);

        $order = Order::create([
            'user_id' => $user->id,
            'service_id' => $request->service_id,
            'account_name' => $request->account_name,
            'paid_status' => 'pending',
            'expiration_date' => Carbon::now()->addDays($service->periodindays)->format('Y-m-d')
        ]);

        return response()->json(['order_id' => $order->id]);
    }

    public function loginUser()
    {
        return view('login');
    }

    public function signupUser()
    {
        if (!auth()->attempt(request(['email', 'password']))) {
            return back()->withErrors([
                'message' => 'Неверный пароль или email'
            ]);
        }

        return redirect('/client');
    }
}
