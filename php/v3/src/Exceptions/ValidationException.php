<?php

namespace Dead4w\App\Exceptions;

use Dead4w\App\Enums\HttpCodes;
use Exception;
use Throwable;

class ValidationException extends Exception
{
    public function __construct(
        ?string $message = 'Validation error',
        ?int $code = HttpCodes::BAD_REQUEST,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}