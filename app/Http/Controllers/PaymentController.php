<?php

namespace App\Http\Controllers;

use App\Order;
use App\Payment\Tinkoff;
use App\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PaymentController extends Controller
{

    /**
     * @param Request $request
     * @return View
     */
    public function success(Request $request): View
    {
        Log::channel('payments')->info('payment ================ success');
        Log::channel('payments')->debug(json_encode($request->all()));

        //TODO remove this after deploy
        if($request->exists('PaymentId') && config('app.debug')) {
            $order = Order::where('payment_id', $request->get('PaymentId'))->first();
            $order->update(['paid_status' => 'active']);
        }
        // ===========================

        return view('success');
    }

    /**
     * @param Request $request
     * @return View
     */
    public function failure(Request $request): View
    {
        Log::channel('payments')->info('payment =============== failure');
        Log::channel('payments')->debug(json_encode($request->all()));

        return view('failure');
    }

    /**
     * @param Request $request
     * @return false|Response
     */
    public function callback(Request $request)
    {
        $tinkoff = Tinkoff::init();

        Log::channel('payments')->info('payment ============== callback');
        Log::channel('payments')->debug(json_encode($request->all()));

        $status = $tinkoff->getState($request->get('PaymentId'));

        if(!$status){
            Log::channel('payments')->error(' ######## PAYMENT NOT VERIFIED ##########');
            Log::channel('payments')->error($tinkoff->error);

            return false;
        }

        Log::channel('payments')->info(' ######## PAYMENT SUCESSFULLY VERIFIED ##########');

        $order = Order::where('payment_id', $request->get('PaymentId'))->first();
        $order->update(['paid_status' => 'active']);
        
        return response('OK', 200);
    }

    /**
     * @param $status
     * @param Request $request
     * @return View
     */
    public function paymentStatus($status, Request $request): View
    {
        if($status === Tinkoff::STATUS_FAIL) {
            return $this->failure($request);
        }

        return $this->success($request);
    }
}
