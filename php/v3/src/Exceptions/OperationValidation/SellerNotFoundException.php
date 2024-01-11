<?php

namespace Dead4w\App\Exceptions\OperationValidation;

class SellerNotFoundException extends OperationValidationException
{

    protected function getClassMessage(): string
    {
        return 'Seller not found!';
    }
}