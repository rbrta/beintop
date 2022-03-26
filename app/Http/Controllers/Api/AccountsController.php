<?php

namespace App\Http\Controllers\Api;

use App\Account;
use App\Http\Controllers\Controller;
use App\Http\Helpers;
use App\Order;
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
            'order_id' => 'required',
            'service_id' => 'required'
        ]);

        $order = $request->user()->orders()->where('paid_status', Order::STATUS_ACTIVE)->findOrFail($request->get('order_id'));
        $service = Service::with('category')->findOrFail($request->get('service_id'));
        $tariffChangePrice = Helpers::getTariffChangePrice($order, $service);

        if($request->isMethod('post')) {
            return Helpers::getPaymentLink($request->user(), $service, $order->account, $tariffChangePrice);
        }

        return response()->json([
            'service' => $service,
            'price' => number_format($tariffChangePrice, 0, ',', ' ')
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required'
        ]);

        $user = $request->user();

        $account = Account::create([
            'account_name' => $request->get('name'),
            'user_id' => $user->id
        ]);

        return response()->json($account);
    }
}
