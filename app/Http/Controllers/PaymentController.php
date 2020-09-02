<?php

namespace App\Http\Controllers;

use App\Order;
use App\Payment\Tinkoff;
use App\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        Log::info('payment =============== failure');
        Log::debug($request->all());
        return view('failure');
    }

    public function pending(Request $request)
    {
        Log::info('payment =============== pending');
        Log::debug($request->all());
        return "pending";
    }


    public function callback(Request $request)
    {   
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

    public function tinkoffTest(Request $request)
    {
        $tinkoff = Tinkoff::init();

        if($request->isMethod('post')) {

            $payment = [
                'OrderId'       => Str::random(),        //Ваш идентификатор платежа
                'Amount'        => '100',           //сумма всего платежа в рублях
                'Language'      => 'ru',            //язык - используется для локализации страницы оплаты
                'Description'   => 'Some buying',   //описание платежа
                'Email'         => 'user@email.com',//email покупателя
                'Phone'         => '89099998877',   //телефон покупателя
                'Name'          => 'Customer name', //Имя покупателя
                'Taxation'      => 'usn_income',     //Налогооблажение
                'SuccessURL'    => route('tinkoff-status', ['status' => 'success']),
                'FailURL'       => route('tinkoff-status', ['status' => 'fail']),
            ];

            $items[] = [
                'Name'  => 'Название товара',
                'Price' => '100',    //цена товара в рублях
                'NDS'   => 'vat20',  //НДС
            ];

            $paymentURL = $tinkoff->paymentURL($payment, $items);

            if(!$paymentURL) {
                return redirect()->back()->withErrors(['payment' => $tinkoff->error]);
            }

            return redirect($tinkoff->payment_url);
        }

        if($request->has('cancel')) {
            $status = $tinkoff->cencelPayment($request->get('cancel'));

            if(!$status){
                return redirect()->back()->withErrors(['status' => $tinkoff->error]);
            }

            return view('tinkoff-test')->with('message', 'Оплата отменена');
        }

        return view('tinkoff-test');
    }

    public function tinkoffPaymentStatus($status, Request $request)
    {
        return view('tinkoff-test');
    }
}
