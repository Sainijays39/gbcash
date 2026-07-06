<?php

namespace App\Exceptions;

use RuntimeException;

class AccountBlockedException extends RuntimeException
{
    protected $message = 'Your account has been blocked. Please contact support.';
}
