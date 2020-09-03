<?php

namespace App\Payment;

class Tinkoff
{
    public static function init() {
        $config = config('services.tinkoff');
        return new \Kenvel\Tinkoff($config['endpoint'], $config['terminal'], $config['secret_key']);
    }
}