<?php

declare(strict_types=1);

namespace App\Enums\Jenkins;

enum Phase: string
{
    case QUEUED = 'QUEUED';
    case STARTED = 'STARTED';
    case COMPLETED = 'COMPLETED';
    case FINALIZED = 'FINALIZED';
}
