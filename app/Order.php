<?php

namespace App;

use App\Payment\Tinkoff;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Validation\ValidationException;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'expiration_date',
        'paid_status',
        'account_id',
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        //'expiration_date' => 'date:Y-m-d',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function service()
    {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }

    /**
     * @return HasOne
     */
    public function account(): HasOne
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }

    /**
     * @return mixed
     * @throws ValidationException
     */
    public function pay()
    {
        $tinkoff = Tinkoff::init();
        $serviceDescription = str_replace('Тарифы', 'Тариф', $this->service->category->name) . ' ' . $this->service->name;

        $payment = [
            'OrderId' => config('app.debug') ? "test_order_{$this->id}" : "order_{$this->id}",
            'Amount' => $this->service->price,
            'Language' => 'ru',
            'Description' => $serviceDescription,
            'Email' => '',
            'Phone' => $this->user->phone,
            'Name' => $this->user->full_name,
            'Taxation' => 'usn_income',
            'SuccessURL' => route('tinkoff-status', ['status' => 'success']),
            'FailURL' => route('tinkoff-status', ['status' => 'fail']),
        ];

        $items[] = [
            'Name' => $serviceDescription,
            'Price' => $this->service->price,
            'NDS' => 'vat20',
        ];

        $paymentURL = $tinkoff->paymentURL($payment, $items);

        if (!$paymentURL) {
            throw ValidationException::withMessages([
                'tinkoff' => $tinkoff->error
            ]);
        }

        $this->payment_id = $tinkoff->payment_id;
        $this->save();

        return $tinkoff->payment_url;
    }
}
