<?php

namespace Dead4w\App\Exceptions\OperationValidation;


class EmptyNotificationTypeException extends OperationValidationException
{

    protected function getClassMessage(): string
    {
        return 'Empty notificationType';
    }
}