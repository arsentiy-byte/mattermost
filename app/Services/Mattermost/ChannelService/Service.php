<?php

declare(strict_types=1);

namespace App\Services\Mattermost\ChannelService;

use App\Contracts\Mattermost\AlfredChannelServiceContract;
use App\Exceptions\Mattermost\ServiceException;
use App\Traits\Mattermost\CallEndpointMethod;
use Arsentiyz\MattermostDriver\Endpoints\ChannelEndpoint;
use Arsentiyz\MattermostDriver\Entities\Channel;
use Arsentiyz\MattermostDriver\Responses\Channel\DirectResponse;
use Illuminate\Http\Client\ConnectionException;

final readonly class Service implements AlfredChannelServiceContract
{
    use CallEndpointMethod;

    public function __construct(
        private ChannelEndpoint $endpoint,
    ) {
    }

    /**
     * @throws ServiceException
     * @throws ConnectionException
     */
    public function direct(string $senderId, string $receiverId): Channel
    {
        /** @var DirectResponse $response */
        $response = $this->call(fn (): DirectResponse => $this->endpoint->direct($senderId, $receiverId));

        return $response->getChannel();
    }
}
