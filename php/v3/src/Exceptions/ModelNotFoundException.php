<?php

namespace Dead4w\App\Exceptions;

use Dead4w\App\Enums\HttpCodes;
use Exception;
use Throwable;

class ModelNotFoundException extends Exception
{
    public function __construct(
        string $model,
        string $id,
        ?int $code = HttpCodes::NOT_FOUND,
        Throwable $previous = null
    ) {
        $message = "Not found $model by id ($id)";

        parent::__construct($message, $code, $previous);
    }
}