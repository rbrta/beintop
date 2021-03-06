<?php

namespace App\Http\Controllers\Api;

use App\Http\Helpers;
use App\ManagerOffer;
use App\Order;
use App\User;
use App\Account;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ManagerController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function clients($id = null, Request $request): JsonResponse
    {
        if($request->isMethod('post')) {
            $user = User::create([
                'phone' => $request->get('phone'),
                'manager' => auth()->user()->id,
                'login_code' => User::generateLoginCode(),
                'full_name' => $request->filled('full_name') ? $request->get('full_name') : '',
            ]);

            $account = Account::create([
                'account_name' => $request->get('account'),
                'user_id' => $user->id
            ]);

            return response()->json($account->fresh('user'));
        }

        if($request->isMethod('delete')) {
            $request->validate([
                'id' => 'required'
            ]);

            if($request->user()->usertype === User::USERTYPE_MANAGER) {
                $user = $request->user()->clients()->findOrFail($request->get('id'));
            } else {
                $user = User::find($request->get('id'));
            }

            $user->accounts()->delete();
            $user->orders()->delete();
            $user->offers()->delete();
            $user->delete();

            return response()->json();
        }

        if($id) {
            $manager = User::where([
                'usertype' => User::USERTYPE_MANAGER
            ])->findOrFail($id);

            $managerClients = User::where('manager', $manager->id)->with('accounts')->get([
                'id',
                'full_name',
                'phone',
            ]);

            return response()->json([
                'manager' => $manager,
                'clients' => $managerClients->each->append('accounts_list')
            ]);
        }

        $clients = User::where('manager', auth()->user()->id)->with(['orders' => function($query) {
            $query->where('paid_status', Order::STATUS_ACTIVE);
            $query->with('service', 'account', 'service.category');
        }])->get();

        $clients = $clients->each->append('accounts_list');

        return response()->json($clients);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addOffer(Request $request): JsonResponse
    {
        $request->validate([
            'tariff_id' => 'required',
            'price' => 'required',
            'user_id' => 'required'
        ]);

        $offer = ManagerOffer::create([
            'manager_id' => $request->user()->id,
            'service_id' => $request->get('tariff_id'),
            'user_id' => $request->get('user_id'),
            'price' => $request->get('price'),
        ]);

        return response()->json([
            'login_code' => $offer->user->login_code,
            'offer_id' => $offer->id
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function acceptOffer(Request $request): JsonResponse
    {
        $request->validate([
            'offer_id' => 'required',
        ]);

        $offer = $request->user()->offers()->findOrFail($request->get('offer_id'));
        $services = Service::with("category")->where('id', $offer->service_id)->get();

        /**
         *
         */
        if($request->isMethod('post')) {
            $request->validate([
                'account_id' => 'required',
                'service_id' => 'required',
            ]);

            $account = $request->user()->accounts()->findOrFail($request->get('account_id'));

            return Helpers::getPaymentLink($request->user(), $services->first(), $account, $offer->price);
        }

        $services->each(static function($service) use ($offer) {
            $service->price = $offer->price;
        });

        return response()->json([
            'services' => $services,
            'offer' => $offer
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function confirmation(Request $request): JsonResponse
    {
        $request->validate([
            'user' => 'required',
            'token' => 'required'
        ]);

        $user = User::where('id', $request->get('user'))->firstOrFail();
        $token = substr(md5($user->email), 0, 8);

        if($request->get('token') !== $token) {
            return response()->json(['message' => '???????????????? ??????????'], 403);
        }

        if($request->isMethod('post')) {
            $request->validate([
                'email' => 'required',
                'full_name' => 'required|min:3',
                'password' => 'required|confirmed|min:6',
            ]);

            $user = User::where('email', $request->get('email'))->firstOrFail();
            $user->full_name = $request->get('full_name');
            $user->email_verified_at = now();
            $user->password = bcrypt($request->get('password'));
            $user->save();

            return response()->json();
        }

        return response()->json(['email' => $user->email]);
    }
}
