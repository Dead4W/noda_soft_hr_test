<?php

namespace Dead4w\App\Exceptions\OperationValidation;

class CreatorNotFoundException extends OperationValidationException
{

    protected function getClassMessage(): string
    {
        return 'Creator not found!';
    }
}