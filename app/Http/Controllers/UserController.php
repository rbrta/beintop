<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use App\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $orders = Order::with(["service.category", "user"])->where("user_id", $user_id)->where("orders.paid_status", "active")->get();
        $services = Service::with('category')->get();
        $user = auth()->user();
        $now = Carbon::now();

        $orders->map(function ($item) use ($now) {
            $item->expiration_date = Carbon::parse($item->expiration_date);
            $item->days = $item->expiration_date->diffInDays($now);
            $item->expiration_date_format = $item->expiration_date->translatedFormat("d F Y");
            return $item;
        });

        return view("client", compact("orders", "user", "services"));
    }




    /**
     * pay from main page as new user
     *
     * @param Request $request
     * @return void
     */
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


        if(! session('idmanager', false) ) {
            $manager = User::randManager();
        } else {
            $manager = session('idmanager');
        }
        

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'manager' => $manager,
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

    /**
     * pay from user panel as exists user
     *
     * @param Request $request
     * @return void
     */
    public function add_new_order(Request $request)
    {
        $customMessages = [
            'account_name.required' => 'Не указано "Имя профиля Instagram"',
        ];

        $request->validate([
            'account_name' => 'required',
            'service_id' => 'required',

        ], $customMessages);

        $service = Service::find($request->service_id);

        $order = Order::create([
            'user_id' => auth()->user()->id,
            'service_id' => $request->service_id,
            'account_name' => $request->account_name,
            'paid_status' => 'pending',
            'expiration_date' => Carbon::now()->addDays($service->periodindays + 1)->format('Y-m-d')
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
                'message' => 'Пользователь с такими данными не найден'
            ]);
        }

        return redirect('/userpanel');
    }


    public function profile(Request $request, $type = null)
    {
        if($request->isMethod('post') && $request->filled('action') && $request->action == 'updateProfile') {
            $request->validate(['email' => 'required', 'full_name' => 'required']);
            User::where('id', Auth::id())->update(['email' => $request->email, 'full_name' => $request->full_name]);

            Session::flash('saved', true);
            return redirect('/userpanel/profile');
        }

        if($request->isMethod('post') && $request->filled('action') && $request->action == 'password') {
            $request->validate(['password' => 'required|confirmed|min:6']);
            User::where('id', Auth::id())->update(['password' => Hash::make($request->password)]);

            Session::flash('saved', true);
            return redirect('/userpanel/profile/password');
        }

        return view('profile', ['user' => auth()->user(), 'type' => $type]);
    }
}
