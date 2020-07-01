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

        if(!$this->validatePayment($dataSet)) {
            Log::channel('payments')->info(' ######## PAYMENT NOT VERIFIED ##########');
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

        $key = env('TEST_PAY_KEY');
        $ik_id = env('PAY_SHOP_ID');

        $ik_sign = $dataSet['ik_sign'];

        unset($dataSet['ik_sign']); // Delete string with signature from dataset
        ksort($dataSet, SORT_STRING); // Sort elements in array by var names in alphabet queue
        array_push($dataSet, $key); // Adding secret key at the end of the string
        $signString = implode(':', $dataSet); // Concatenation calues using symbol ":"
        $sign = base64_encode(md5($signString, true)); // Get MD5 hash as binare view using generate string and code it in BASE64

        Log::channel('payments')->info('PAYMENT SIGN:' . $sign);

        if($dataSet['ik_co_id'] != $ik_id || $dataSet['ik_inv_st'] != 'success' || $sign != $ik_sign){
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

    public function test()
    {
        $data = [
            'ik_co_id' => '5ed3d7051ae1bd39008b457b',
            'ik_co_prs_id' => '406649888130',
            'ik_inv_id' => '226606417',
            'ik_inv_st' => 'success',
            'ik_inv_crt' => '2020-07-01 15:39:28',
            'ik_inv_prc' => '2020-07-01 15:39:28',
            'ik_trn_id' => NULL,
            'ik_pm_no' => 'ID_14',
            'ik_pw_via' => 'test_interkassa_test_xts',
            'ik_am' => '29',
            'ik_co_rfn' => '27.84',
            'ik_ps_price' => '29',
            'ik_cur' => 'RUB',
            'ik_desc' => 'maxi тариф 100',
            'ik_sign' => '4K1K+r4CR53z0AwrmO7fXw==',
        ];

        dd($this->validatePayment($data));

    }
}
