<?php

namespace Dead4w\App\Services;

use Dead4w\App\Exceptions\NotifySendException;

class NotificationManager
{

    public static function send(
        int $contractorId,
        int $secondContractorId,
        string $event,
        string $payload,
        array $templateData,
    ): bool {
        if ($contractorId === 0) {
            // fakes error
            throw new NotifySendException("Failed to send notify to this user ($contractorId)");
        }

        // fakes send notify
        return true;
    }

}