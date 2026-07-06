<?php

namespace App\Exceptions;

use RuntimeException;

class InvalidOtpException extends RuntimeException
{
    protected $message = 'The OTP you entered is invalid or has expired.';
}
