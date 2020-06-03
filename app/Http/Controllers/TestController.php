<?php

namespace App\Http\Controllers;

use App\Order;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function success()
    {
        $post = $_POST;
        Log::debug($post);
        Log::debug('success!!!');
        return "success";
    }

    public function failure()
    {
        $post = $_POST;
        Log::debug($post);
        Log::debug('failure!!!');
        return "failure";
    }

    public function pending()
    {
        $post = $_POST;
        Log::debug($post);
        Log::debug('pending!!!');
        return "pending";
    }


    public function callback()
    {   
        $post = $_POST;
        $key = env("PAY_KEY");
        $ik_id = env("PAY_SHOP_ID");
        $dataSet = $post;

        unset($dataSet['ik_sign']); // Delete string with signature from dataset
        ksort($dataSet, SORT_STRING); // Sort elements in array by var names in alphabet queue
        array_push($dataSet, $key); // Adding secret key at the end of the string
        $signString = implode(':', $dataSet); // Concatenation calues using symbol ":"
        $sign = base64_encode(md5($signString, true)); // Get MD5 hash as binare view using generate string and code it in BASE64

        $order_price = '1.44';
        if($dataSet['ik_co_id'] != $ik_id || $dataSet['ik_inv_st'] != 'success' 
        || $dataSet['ik_am'] != $order_price || $sign != $_POST['ik_sign']){
            Log::debug('error');
            return;
        }
  
        $order_id = $dataSet['ik_pm_no'];
        str_replace('ID_', '', $order_id);
        Order::where('id', $order_id)->update(['paid_status' => 'active']);
        
        Log::debug('success');
        return "success";
    }

    public function pay()
    {
        $url = env("PAY_URL");
        $shop_id = env("PAY_SHOP_ID");
        $callback = $url . '/payment/callback';
        $success = $url . '/payment/success';
        $failure = $url . '/payment/failure';
        $pending = $url . '/payment/pending';

        return view('testpay', compact('success', 'failure', 'callback', 'pending', 'shop_id'));
    }
}
