<?php

namespace App\Http\Controllers;

use App\Order;
use App\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{

    public function success(Request $request)
    {
        Log::info('payment ================ success');
        Log::debug($request->all());

        //TODO remove this after deploy
        if(env('APP_ENV') == 'local') {
            $order_id = str_replace('ID_', '', $request->ik_pm_no);

            $order = Order::where("id", $order_id)->first();
            $order->update(['paid_status' => 'active']);

        }
        // ===========================

        return view('success');
    }

    public function failure(Request $request)
    {
        Log::channel('payments')->info('payment =============== failure');
        Log::channel('payments')->debug($request->all());
        return view('failure');
    }

    public function pending(Request $request)
    {
        Log::channel('payments')->info('payment =============== pending');
        Log::channel('payments')->debug($request->all());
        return "pending";
    }


    public function callback(Request $request)
    {   
        Log::channel('payments')->info('payment ============== callback');
        Log::channel('payments')->debug($request->all());
        $dataSet = $request->all();
        if($this->validatePayment($dataSet)) {
            return false;
        }

        $order_id = $dataSet['ik_pm_no'];
        $order_id = str_replace('ID_', '', $order_id);

        $order = Order::where("id", $order_id)->first();
        $order->update(['paid_status' => 'active']);
        
        return response('success', 200);
    }


    private function validatePayment($dataSet)
    {
        Log::channel('payments')->info('payment ============== validatePayment');
        Log::channel('payments')->debug($dataSet);

        $key = env('PAY_KEY');
        $ik_id = env('PAY_SHOP_ID');

        unset($dataSet['ik_sign']); // Delete string with signature from dataset
        ksort($dataSet, SORT_STRING); // Sort elements in array by var names in alphabet queue
        array_push($dataSet, $key); // Adding secret key at the end of the string
        $signString = implode(':', $dataSet); // Concatenation calues using symbol ":"
        $sign = base64_encode(md5($signString, true)); // Get MD5 hash as binare view using generate string and code it in BASE64

        if($dataSet['ik_co_id'] != $ik_id || $dataSet['ik_inv_st'] != 'success' || $sign != $dataSet['ik_sign']){
            Log::debug('validation payment error');
            return false;
        }

        return true;
  
    }

    public function pay()
    {
        $url = env("APP_URL");
        $shop_id = "";
        $callback = $url . '/payment/callback';
        $success = $url . '/payment/success';
        $failure = $url . '/payment/failure';
        $pending = $url . '/payment/pending';

        return view('testpay', compact('success', 'failure', 'callback', 'pending', 'shop_id'));
    }
}
