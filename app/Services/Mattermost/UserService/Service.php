<?php

declare(strict_types=1);

namespace App\Services\Mattermost\UserService;

use App\Contracts\Mattermost\UserServiceContract;
use App\Exceptions\Mattermost\ServiceException;
use App\Traits\Mattermost\CallEndpointMethod;
use Arsentiyz\MattermostDriver\Collections\UserCollection;
use Arsentiyz\MattermostDriver\Endpoints\UserEndpoint;
use Arsentiyz\MattermostDriver\Requests\User\IndexRequest;
use Arsentiyz\MattermostDriver\Responses\User\IndexResponse;
use Illuminate\Http\Client\ConnectionException;

final readonly class Service implements UserServiceContract
{
    use CallEndpointMethod;

    public function __construct(
        private UserEndpoint $endpoint,
    ) {
    }

    /**
     * @throws ServiceException
     * @throws ConnectionException
     */
    public function index(IndexRequest $request): UserCollection
    {
        /** @var IndexResponse $response */
        $response = $this->call(fn (): IndexResponse => $this->endpoint->index($request));

        return $response->getUsers();
    }

    /**
     * @throws ConnectionException
     * @throws ServiceException
     */
    public function all(?string $inTeamId = null, ?string $notInTeamId = null): UserCollection
    {
        $users = new UserCollection();

        $page = 0;
        do {
            $usersFromResponse = $this->index(new IndexRequest(page: $page++, inTeam: $inTeamId, notInTeam: $notInTeamId));
            $users = $users->merge($usersFromResponse);
        } while ($usersFromResponse->isNotEmpty());

        return $users;
    }
}
