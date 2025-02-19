<?php

declare(strict_types=1);

namespace App\Services\Mattermost\TeamService;

use App\Contracts\Mattermost\TeamServiceContract;
use App\Exceptions\Mattermost\ServiceException;
use App\Traits\Mattermost\CallEndpointMethod;
use Arsentiyz\MattermostDriver\Collections\ChannelCollection;
use Arsentiyz\MattermostDriver\Collections\TeamCollection;
use Arsentiyz\MattermostDriver\Endpoints\TeamEndpoint;
use Arsentiyz\MattermostDriver\Requests\Team\ChannelsRequest;
use Arsentiyz\MattermostDriver\Requests\Team\IndexRequest;
use Arsentiyz\MattermostDriver\Responses\Team\ChannelsResponse;
use Arsentiyz\MattermostDriver\Responses\Team\IndexResponse;

final readonly class Service implements TeamServiceContract
{
    use CallEndpointMethod;

    public function __construct(
        private TeamEndpoint $endpoint,
    ) {
    }

    /**
     * @throws ServiceException
     */
    public function getTeams(IndexRequest $request): TeamCollection
    {
        /** @var IndexResponse $response */
        $response = $this->call(fn (): IndexResponse => $this->endpoint->index($request));

        return $response->getTeams();
    }

    /**
     * @throws ServiceException
     */
    public function getPublicChannels(ChannelsRequest $request): ChannelCollection
    {
        /** @var ChannelsResponse $response */
        $response = $this->call(fn (): ChannelsResponse => $this->endpoint->publicChannels($request));

        return $response->getChannels();
    }

    /**
     * @throws ServiceException
     */
    public function getPrivateChannels(ChannelsRequest $request): ChannelCollection
    {
        /** @var ChannelsResponse $response */
        $response = $this->call(fn (): ChannelsResponse => $this->endpoint->privateChannels($request));

        return $response->getChannels();
    }
}
