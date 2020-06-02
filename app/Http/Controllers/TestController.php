<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function success()
    {
        return "success";
    }

    public function failure()
    {
        return "failure";
    }

    public function callback()
    {
        return "callback";
    }

    public function pay()
    {
        return view('testpay');
    }
}
