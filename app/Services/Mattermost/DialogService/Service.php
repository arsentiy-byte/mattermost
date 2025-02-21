<?php

declare(strict_types=1);

namespace App\Services\Mattermost\DialogService;

use App\Contracts\Mattermost\DialogServiceContract;
use App\Exceptions\Mattermost\ServiceException;
use App\Traits\Mattermost\CallEndpointMethod;
use Arsentiyz\MattermostDriver\Endpoints\DialogEndpoint;
use Arsentiyz\MattermostDriver\Requests\Action\Dialog\OpenRequest;
use Arsentiyz\MattermostDriver\Responses\Action\Dialog\OpenResponse;
use Illuminate\Http\Client\ConnectionException;

final readonly class Service implements DialogServiceContract
{
    use CallEndpointMethod;

    public function __construct(
        private DialogEndpoint $endpoint,
    ) {
    }

    /**
     * @throws ServiceException
     * @throws ConnectionException
     */
    public function open(OpenRequest $request): void
    {
        $this->call(fn (): OpenResponse => $this->endpoint->open($request));
    }
}
