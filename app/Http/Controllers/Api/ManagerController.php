<?php

namespace App\Http\Controllers\Api;

use App\Http\Helpers;
use App\ManagerOffer;
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

    public function addOffer(Request $request)
    {
        $request->validate([
            'tariff_id' => 'required',
            'price' => 'required',
            'user_id' => 'required'
        ]);

        $offer = ManagerOffer::create([
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
            'services' => $services->groupBy('category.name'),
            'offer' => $offer
        ]);
    }
}
