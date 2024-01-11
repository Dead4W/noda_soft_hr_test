<?php

namespace Dead4w\App\Exceptions;


use Dead4w\App\Enums\HttpCodes;
use Exception;
use Throwable;

class StateNotFoundException extends Exception
{

    public function __construct(
        int $stateId,
        ?int $code = HttpCodes::BAD_REQUEST,
        Throwable $previous = null
    ) {
        $message = printf($this->getClassMessage(), $stateId);

        parent::__construct($message, $code, $previous);
    }

    protected function getClassMessage(): string
    {
        return 'State with id (%s) not found';
    }

}