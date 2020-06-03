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
        //$post = $_REQUEST;

        $post = array (
            'ik_co_id' => '5ed3d7051ae1bd39008b457b',
            'ik_co_prs_id' => '406649888130',
            'ik_inv_id' => '220551724',
            'ik_inv_st' => 'success',
            'ik_inv_crt' => '2020-06-03 11:42:16',
            'ik_inv_prc' => '2020-06-03 11:42:16',
            'ik_trn_id' => '',
            'ik_pm_no' => 'ID_2',
            'ik_pw_via' => 'test_interkassa_test_xts',
            'ik_am' => '1.44',
            'ik_co_rfn' => '1.44',
            'ik_ps_price' => '1.5',
            'ik_cur' => 'RUB',
            'ik_desc' => 'Payment Description',
            'ik_sign' => 'e6zooRxL4w1CKmBA9KQtdA==',
        );

        $key = 'UpMgttstrxSG5xzI';
        $ik_id = '5ed3d7051ae1bd39008b457b';
        $dataSet = $post;

        unset($dataSet['ik_sign']); // Delete string with signature from dataset
        ksort($dataSet, SORT_STRING); // Sort elements in array by var names in alphabet queue
        array_push($dataSet, $key); // Adding secret key at the end of the string
        $signString = implode(':', $dataSet); // Concatenation calues using symbol ":"
        $sign = base64_encode(md5($signString, true)); // Get MD5 hash as binare view using generate string and code it in BASE64
        
        Log::debug($post['ik_sign'] . '  <====>  ' . $sign);
        return $post['ik_sign'] . '  <====>  ' . $sign;
        //$order_price = '1.44';
        // if($dataSet['ik_co_id'] != $ik_id || $dataSet['ik_inv_st'] != 'success' 
        // || $dataSet['ik_am'] != $order_price || $sign != $_POST['ik_sign']){
        //     return "";
        // }
  
        return "+";
        $order_id = $dataSet['ik_pm_no'];
        str_replace('ID_', '', $order_id);
        Order::where('id', $order_id)->update(['paid_status' => 'active']);

        return "success";
    }

    public function pay()
    {
        dd(env("APP_URL"));
        $url = env("PAY_URL");
        $callback = $url . '/payment/callback';
        $success = $url . '/payment/success';
        $failure = $url . '/payment/failure';
        $pending = $url . '/payment/pending';

        return view('testpay', compact('success', 'failure', 'callback', 'pending'));
    }
}
