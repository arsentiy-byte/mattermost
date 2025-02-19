<?php

declare(strict_types=1);

namespace App\Traits\Mattermost;

use App\Exceptions\Mattermost\ServiceException;
use Arsentiyz\MattermostDriver\Responses\ErrorResponse;
use Arsentiyz\MattermostDriver\Responses\Response;

trait CallEndpointMethod
{
    /**
     * @throws ServiceException
     */
    public function call(callable $callback): mixed
    {
        /** @var Response $response */
        $response = $callback();

        if ($response->isFailed()) {
            /** @var ErrorResponse $errorResponse */
            $errorResponse = $response->getErrorResponse();

            $message = $errorResponse->getDetailedError();

            if (empty($message)) {
                $message = $errorResponse->getMessage() ?? 'Unknown error';
            }

            throw ServiceException::receivedFailedResponse($message, $errorResponse->getStatusCode());
        }

        return $response;
    }
}
