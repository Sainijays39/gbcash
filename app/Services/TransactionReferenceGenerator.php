<?php

namespace App\Services;

use Illuminate\Support\Str;

class TransactionReferenceGenerator
{
    public function generate(string $prefix): string
    {
        return sprintf(
            '%s-%s-%s',
            strtoupper($prefix),
            now()->format('ymd'),
            strtoupper(Str::random(6)),
        );
    }
}
