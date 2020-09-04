<?php

namespace App\Http\Controllers;

use App\Payment\Tinkoff;
use App\User;
use App\Order;
use App\Service;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index($showDetails = false)
    {

        $user = auth()->user();
        $orders = Order::with(["service.category", "user"])->where("user_id", $user->id)->where("orders.paid_status", "active")->get();
        $services = Service::with('category')->get();
        $now = Carbon::now();

        $orders->map(function ($item) use ($now) {
            $item->expiration_date = Carbon::parse($item->expiration_date);
            $item->days = $item->expiration_date->diffInDays($now);
            $item->expiration_date_format = $item->expiration_date->translatedFormat("d F Y");
            return $item;
        });


        $showService = $showDetails ? session::get('idservice') : 'false';

        return view("client", compact("orders", "user", "services", "showService"));
    }


    /**
     * pay from main page as new user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function pay_service_guest(Request $request): JsonResponse
    {
        $customMessages = [
            'account_name.required' => 'Не указано "Имя профиля Instagram"',
            'service_id.required' => 'Не указан "Тариф"',
            'phone.required' => 'Не указан номер телефона',
        ];

        $request->validate([
            'account_name' => 'required',
            'service_id' => 'required',
            'phone' => 'required',

        ], $customMessages);


        if(!session('idmanager', false) ) {
            $managerUser = User::randManager();
            $manager = $managerUser ? $managerUser->id : null;
        } else {
            $manager = session('idmanager');
        }
        

        $user = User::create([
            'insta_account' => $request->account_name,
            'phone' => $request->phone,
            'manager' => $manager,
            'login_code' => User::generateLoginCode(),
        ]);

        Auth::login($user, true);

        Cookie::queue('isuser', true, 525600);

        $service = Service::find($request->service_id);

        $order = Order::create([
            'user_id' => $user->id,
            'service_id' => $request->service_id,
            'account_name' => $request->account_name,
            'paid_status' => 'pending',
            'expiration_date' => Carbon::now()->addDays($service->periodindays)->format('Y-m-d H:i:s')
        ]);

        $payment = $order->pay();

        return response()->json(['redirect_url' => $payment]);
    }

    /**
     * pay from user panel as exists user
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function add_new_order(Request $request): JsonResponse
    {
        $customMessages = [
            'account_name.required' => 'Не указано "Имя профиля Instagram"',
        ];

        $request->validate([
            'account_name' => 'required',
            'service_id' => 'required',

        ], $customMessages);

        $service = Service::find($request->service_id);

        /**
         * @var $order Order
         */
        $order = Order::create([
            'user_id' => auth()->user()->id,
            'service_id' => $request->service_id,
            'account_name' => $request->account_name,
            'paid_status' => 'pending',
            'expiration_date' => Carbon::now()->addDays($service->periodindays)->format('Y-m-d H:i:s')
        ]);

        $payment = $order->pay();

        return response()->json(['redirect_url' => $payment]);
    }



    public function loginUser(Request $request)
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
