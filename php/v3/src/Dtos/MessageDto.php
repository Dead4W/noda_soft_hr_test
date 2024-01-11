<?php

namespace Dead4w\App\Dtos;

class MessageDto
{

    public function __construct(
        public string $emailFrom,
        public string $emailTo,
        public string $subject,
        public string $message,
    ) {

    }

}