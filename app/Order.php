<?php

namespace App;

use App\User;
use App\Service;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'expiration_date',
        'paid_status',
        'account_name',
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'expiration_date' => 'date:Y-m-d',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function service()
    {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }
}
