<?php

namespace Dead4w\App\Exceptions\OperationValidation;

use Dead4w\App\Enums\HttpCodes;
use Throwable;

class NotificationClientException extends OperationValidationException
{

    public function __construct(
        string $message,
        ?int $code = HttpCodes::BAD_REQUEST,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    protected function getClassMessage(): string
    {
        return '';
    }
}