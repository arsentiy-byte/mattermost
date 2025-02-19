<?php

declare(strict_types=1);

namespace App\Exceptions\Mattermost;

use Exception;

final class ServiceException extends Exception
{
    public static function receivedFailedResponse(string $message, int $code): self
    {
        return new self(sprintf('Received failed response with message: %s', $message), $code);
    }
}
