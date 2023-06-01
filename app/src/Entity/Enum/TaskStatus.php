<?php
/**
 * Task Status
 */

namespace App\Entity\Enum;

use App\Entity\Task;

/**
 * Enum TaskStatus.
 */

enum TaskStatus: int
{
    case STATUS_ONE = 1;
    case STATUS_TWO = 2;

    public function label(): int
    {
        return match ($this) {
            TaskStatus::STATUS_ONE => 1,
            TaskStatus::STATUS_TWO => 2,
        };
    }
}