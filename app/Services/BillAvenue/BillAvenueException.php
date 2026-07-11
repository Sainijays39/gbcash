<?php

namespace App\Services\BillAvenue;

use RuntimeException;

class BillAvenueException extends RuntimeException
{
    public function __construct(
        string $message,
        public readonly ?string $responseCode = null,
        public readonly array $response = [],
    ) {
        parent::__construct($message);
    }
}
