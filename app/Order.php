<?php

namespace App;

use App\Payment\Tinkoff;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Validation\ValidationException;

class Order extends Model
{
    public const STATUS_TERMINATED = 'terminated';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_PENDING = 'pending';

    protected $fillable = [
        'user_id',
        'service_id',
        'expiration_date',
        'paid_status',
        'account_id',
        'total'
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        //'expiration_date' => 'date:Y-m-d',
    ];

    protected $appends = [
        'days',
        'expiration_date_format',
        'expiration_ms',
        'created_at_format',
        'is_expired',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function service()
    {
        return $this->hasOne(Service::class, 'id', 'service_id')->withTrashed();
    }

    /**
     * @return HasOne
     */
    public function account(): HasOne
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }

    /**
     * @return int
     */
    public function getDaysAttribute(): int
    {
        return now()->diffInDays(Carbon::parse($this->expiration_date));
    }

    /**
     * @return string
     */
    public function getCreatedAtFormatAttribute(): string
    {
        return Carbon::parse($this->created_at)->translatedFormat("d F Y");
    }

    /**
     * @return string
     */
    public function getExpirationDateFormatAttribute(): string
    {
        return Carbon::parse($this->expiration_date)->translatedFormat("d F Y");
    }

    /**
     * @return int
     */
    public function getExpirationMsAttribute(): int
    {
        $expirationDate = $this->expiration_date ? now()->diffInMilliseconds(Carbon::parse($this->expiration_date), false) : 0;

        return $expirationDate > 0 ? $expirationDate : 0;
    }

    /**
     * @return bool
     */
    public function getIsExpiredAttribute()
    {
        return $this->expiration_ms <= 0;
    }

    /**
     * @return mixed
     * @throws ValidationException
     */
    public function pay()
    {
        $tinkoff = Tinkoff::init();
        $serviceDescription = str_replace('????????????', '??????????', $this->service->category->name) . ' ' . $this->service->name;

        $payment = [
            'OrderId' => config('app.debug') ? "test_order_{$this->id}" : "order_{$this->id}",
            'Amount' => $this->total,
            'Language' => 'ru',
            'Description' => $serviceDescription,
            'Email' => $this->user->email,
            'Phone' => $this->user->phone,
            'Name' => $this->user->full_name,
            'Taxation' => 'usn_income',
            'SuccessURL' => url('/tinkoff/success'),
            'FailURL' => url('/tinkoff/fail'),
        ];

        $items[] = [
            'Name' => $serviceDescription,
            'Price' => $this->total,
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

    /**
     * @return Order|null
     */
    public function getPrevious()
    {
        return self::where([
            'user_id' => $this->user_id,
            'account_id' => $this->account_id,
        ])
            ->where('id', '!=', $this->id)
            ->where('paid_status', '!=', Order::STATUS_PENDING)
            ->whereHas('service', function($query) {
                $query->where('type', '=', $this->service->type);
            })
            ->latest()
            ->first();
    }
}
