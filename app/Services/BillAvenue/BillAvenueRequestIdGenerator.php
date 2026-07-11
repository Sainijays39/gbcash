<?php

namespace App\Services\BillAvenue;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Generates the 35-character alphanumeric requestId BillAvenue requires on every call.
 *
 * Per spec: <27 random alphanumeric characters><YDDDhhmm>
 *   Y   = last digit of the current year
 *   DDD = day-of-year, zero-padded to 3 digits
 *   hh  = hour, 24-hour format
 *   mm  = minute
 */
class BillAvenueRequestIdGenerator
{
    public function generate(): string
    {
        $now = Carbon::now();

        $suffix = substr((string) $now->year, -1)
            .str_pad((string) $now->dayOfYear, 3, '0', STR_PAD_LEFT)
            .$now->format('Hi');

        $random = strtoupper(Str::random(27));

        return $random.$suffix;
    }
}
