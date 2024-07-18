<?php

namespace App\Helpers;

use NumberFormatter;
class Currency
    {
    public function __invoke(...$arguments)
    {
        return static::format(...$arguments);
    }

    public static function format($amount, $currency = null)
    {

        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
        if ($currency === null) {
            $currency = config('app.currency');
        }
        return $formatter->formatCurrency($amount, $currency);

    }
    }
