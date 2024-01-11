<?php

namespace Dead4w\App\Exceptions\OperationValidation;

use Dead4w\App\Enums\HttpCodes;
use Throwable;

class TemplateDataIsEmpty extends OperationValidationException
{

    public function __construct(
        string $key,
        ?int $code = HttpCodes::BAD_REQUEST,
        Throwable $previous = null
    ) {
        $message = printf($this->getClassMessage(), $key);

        parent::__construct($message, $code, $previous);
    }

    protected function getClassMessage(): string
    {
        return 'Template Data (%s) is empty!';
    }
}