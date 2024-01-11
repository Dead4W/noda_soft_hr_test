<?php

namespace Dead4w\App\Services;


use Dead4w\App\Dtos\MessageDto;

class MessagesClient
{

    /**
     * @param MessageDto[] $messages
     * @param int $contractorId
     * @param int|null $secondContractorId
     * @param string $event
     * @return void
     */
    public static function sendMessage(
        array $messages,
        int $contractorId,
        ?int $secondContractorId = null,
        ?string $event = null,
        ?string $payload = null,
    ): void {
        // fakes send message
    }

}