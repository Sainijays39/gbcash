<?php

namespace App\Services\BillAvenue;

use RuntimeException;
use Throwable;

class BillAvenueException extends RuntimeException
{
    public function __construct(
        string $message,
        public readonly ?string $responseCode = null,
        public readonly array $response = [],
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, previous: $previous);
    }
}
