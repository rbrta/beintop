<?php

namespace App\Http\Controllers\Api;

use App\Account;
use App\Http\Controllers\Controller;
use App\Http\Helpers;
use App\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AccountsController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        if($request->exists('id')) {
            return response()->json($request->user()->accounts()->findOrFail($request->get('id')));
        }

        return response()->json(auth()->user()->accounts);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function changeTariff(Request $request): JsonResponse
    {
        $request->validate([
            'account_id' => 'required',
            'service_id' => 'required'
        ]);

        /**
         * @var $account Account
         */
        $account = $request->user()->accounts()->findOrFail($request->get('account_id'));
        $service = Service::with('category')->findOrFail($request->get('service_id'));

        if($request->isMethod('post')) {
            return Helpers::getPaymentLink($request->user(), $service, $account, $account->getTariffChangePrice($service));
        }

        return response()->json([
            'service' => $service,
            'price' => number_format($account->getTariffChangePrice($service), 0, ',', ' ')
        ]);
    }
}
