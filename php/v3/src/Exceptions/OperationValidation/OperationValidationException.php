<?php

namespace Dead4w\App\Exceptions\OperationValidation;


use Dead4w\App\Enums\HttpCodes;
use Dead4w\App\Exceptions\ValidationException;
use Throwable;

abstract class OperationValidationException extends ValidationException
{

    public const MESSAGE = 'Operation validation error';

    public function __construct(
        ?string $message = null,
        ?int $code = HttpCodes::BAD_REQUEST,
        Throwable $previous = null
    ) {
        $message = $message ?? $this->getClassMessage();

        parent::__construct($message, $code, $previous);
    }

    abstract protected function getClassMessage(): string;

}