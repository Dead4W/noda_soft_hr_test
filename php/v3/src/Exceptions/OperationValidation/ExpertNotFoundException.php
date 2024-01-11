<?php

namespace Dead4w\App\Exceptions\OperationValidation;

class ExpertNotFoundException extends OperationValidationException
{

    protected function getClassMessage(): string
    {
        return 'Expert not found!';
    }
}