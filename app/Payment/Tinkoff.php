<?php

namespace App\Payment;

class Tinkoff
{
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAIL = 'fail';

    public static function init() {
        $config = config('services.tinkoff');
        return new \Kenvel\Tinkoff($config['endpoint'], $config['terminal'], $config['secret_key']);
    }
}