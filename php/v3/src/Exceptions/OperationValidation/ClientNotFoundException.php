<?php

namespace Dead4w\App\Exceptions\OperationValidation;

class ClientNotFoundException extends OperationValidationException
{

    protected function getClassMessage(): string
    {
        return 'Client not found!';
    }
}