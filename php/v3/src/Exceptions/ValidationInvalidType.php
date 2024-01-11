<?php

namespace Dead4w\App\Exceptions;

use Dead4w\App\Enums\HttpCodes;
use Throwable;

class ValidationInvalidType extends ValidationException
{
    public function __construct(
        ?string $message = 'Invalid type for input data',
        ?int $code = HttpCodes::BAD_REQUEST,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}