<?php

namespace App\Http\Controllers;

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
        Log::debug($post);
        Log::debug('callback!!!');
        return "callback";
    }

    public function pay()
    {
        $url = env("PAY_URL");
        $callback = $url . '/payment/callback';
        $success = $url . '/payment/success';
        $failure = $url . '/payment/failure';
        $pending = $url . '/payment/pending';

        return view('testpay', compact('success', 'failure', 'callback', 'pending'));
    }
}
