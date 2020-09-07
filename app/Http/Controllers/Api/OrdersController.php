<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        $service = Service::find($request->get('service_id'));

        /**
         * @var $user User
         */
        $user = $request->user();

        /**
         * @var $order Order
         */
        $order = Order::create([
            'user_id' => $user->id,
            'service_id' => $request->get('service_id'),
            'account_id' => $user->accounts()->first()->id,
            'paid_status' => 'pending',
            'expiration_date' => Carbon::now()->addDays($service->periodindays)->format('Y-m-d H:i:s')
        ]);

        $payment = $order->pay();

        return response()->json(['redirect_url' => $payment]);
    }
}
