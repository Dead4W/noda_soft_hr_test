<?php

namespace Dead4w\App\Operations;


use Dead4w\App\Dtos\ReferencesOperationDto;
use Dead4w\App\Dtos\ReferencesOperationResultDto;

abstract class ReferencesOperation
{

    abstract public function doOperation(ReferencesOperationDto $data): ReferencesOperationResultDto;

}