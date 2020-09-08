<?php

namespace App\Http\Controllers\Api;

use App\Account;
use App\Http\Controllers\Controller;
use App\Http\Helpers;
use App\Order;
use App\Service;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrdersController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        /**
         * @var $user User
         */
        $user = $request->user();
        $relations = ['user', 'service.category', 'account'];
        $now = Carbon::now();

        if($request->exists('id')) {
            $order = $user->orders()->with($relations)->findOrFail($request->get('id'));
            $order->expiration_date = Carbon::parse($order->expiration_date);
            $order->days = $order->expiration_date->diffInDays($now);
            $order->expiration_date_format = $order->expiration_date->translatedFormat("d F Y");
            return response()->json($order);
        }

        if($request->get('tab') === 'archive') {
            $orders = $user->archivedOrders()->with($relations)->get();
        } else {
            $orders = $user->activeOrders()->with($relations)->get();
        }

        $orders->each(static function ($item) use ($now) {
            $item->expiration_date = Carbon::parse($item->expiration_date);
            $item->days = $item->expiration_date->diffInDays($now);
            $item->expiration_date_format = $item->expiration_date->translatedFormat("d F Y");
        });

        return response()->json($orders);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'service_id' => 'required',
        ]);

        if(!$request->filled('account_name')) {
            $request->validate([
                'account_id' => 'required',
            ]);
        }

        $service = Service::find($request->get('service_id'));

        /**
         * @var $user User
         */
        $user = $request->user();

        if($request->filled('account_name')) {
            $account = Account::create([
                'user_id' => $user->id,
                'account_name' => $request->get('account_name')
            ]);
        } else {
            $account = $user->accounts()->findOrFail($request->get('account_id'));
        }

        return Helpers::getPaymentLink($user, $service, $account, $service->price);
    }

}
