<?php

namespace App\Http;

use App\Order;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class Helpers
{
    /**
     * @param $user
     * @param $service
     * @param $account
     * @param $total
     * @return JsonResponse
     * @throws ValidationException
     */
    public static function getPaymentLink($user, $service, $account, $total): JsonResponse
    {
        /**
         * @var $order Order
         */
        $order = Order::create([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'account_id' => $account->id,
            'total' => $total,
            'paid_status' => 'pending',
            'expiration_date' => Carbon::now()->addDays($service->periodindays)->format('Y-m-d H:i:s')
        ]);

        $payment = $order->pay();

        return response()->json(['redirect_url' => $payment]);
    }

}
