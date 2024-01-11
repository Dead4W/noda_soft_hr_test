<?php

namespace Dead4w\App\Enums;

use Dead4w\App\Exceptions\StateNotFoundException;

class Status
{

    public const STATE_NULL = 0;
    public const STATE_COMPLETED = 1;
    public const STATE_PENDING = 2;
    public const STATE_REJECTED = 3;

    protected const STATE_NAMES = [
        self::STATE_NULL => 'Null',
        self::STATE_COMPLETED => 'Completed',
        self::STATE_PENDING => 'Pending',
        self::STATE_REJECTED => 'Rejected',
    ];

    /**
     * @throws StateNotFoundException
     */
    public static function getNameByState(int $id): string {
        if (!isset(self::STATE_NAMES[$id])) {
            throw new StateNotFoundException($id);
        }

        return self::STATE_NAMES[$id];
    }

    public static function existStatus(int $id): bool {
        return isset(self::STATE_NAMES[$id]);
    }

}