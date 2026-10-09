<?php

namespace App\Support;

use Nitro\Attributes\Browser;

#[Browser]
final class Money
{
    public const CURRENCY = '£';

    /** Formats an amount in pence, such as 1250 as "£12.50". */
    public static function format(int $pence): string
    {
        return self::CURRENCY.number_format($pence / 100, 2);
    }
}
