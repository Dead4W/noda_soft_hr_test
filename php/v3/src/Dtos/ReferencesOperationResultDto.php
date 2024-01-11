<?php

namespace Dead4w\App\Dtos;

use Dead4w\App\Exceptions\NotifySendException;

class ReferencesOperationResultDto
{

    public function __construct(
        public bool $notificationEmployeeByEmail = false,
        public bool $notificationClientByEmail = false,
        public bool $notificationClientBySmsIsSend = false,
        public ?NotifySendException $notificationClientBySmsError = null,
    ) {

    }

}