<?php

declare(strict_types=1);

namespace App\Enums\Jenkins;

enum Status: string
{
    case SUCCESS = 'SUCCESS';
    case FAILURE = 'FAILURE';
    case UNSTABLE = 'UNSTABLE';
    case ABORTED = 'ABORTED';
    case NOT_BUILT = 'NOT_BUILT';
    case NO_VALUE = 'NO_VALUE';
}
