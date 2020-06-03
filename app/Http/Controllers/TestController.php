<?php

namespace App\Http\Controllers;

use App\Order;
use App\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function test()
    {
        return view('success');
        
        $first = Order::where("id", "4")->with("service")->first();
        $exp = Carbon::now()->addDays($first->service->periodindays);
        $first->update(['paid_status' => 'active','expiration_date' => $exp]);

        return $first;
        return "test";
    }

    public function success()
    {
        Log::debug('success!!!');
        return view('success');
    }

    public function failure()
    {
        Log::debug('failure!!!');
        return view('failure');
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
        //$key = env("PAY_KEY");
        //$ik_id = env("PAY_SHOP_ID");
        $key = "UpMgttstrxSG5xzI";
        $ik_id = "5ed3d7051ae1bd39008b457b";
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
        $first = Order::where("id", $order_id)->with("service")->first();
        $exp = Carbon::now()->addDays($first->service->periodindays);
        $first->update(['paid_status' => 'active','expiration_date' => $exp]);
        
        Log::debug('success');
        return "success";
    }

    public function pay()
    {
        $url = env("PAY_URL");
        //$shop_id = env("PAY_SHOP_ID");
        $shop_id = "5ed3d7051ae1bd39008b457b";
        $callback = $url . '/payment/callback';
        $success = $url . '/payment/success';
        $failure = $url . '/payment/failure';
        $pending = $url . '/payment/pending';

        return view('testpay', compact('success', 'failure', 'callback', 'pending', 'shop_id'));
    }
}
