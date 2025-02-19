<?php

declare(strict_types=1);

namespace App\Services\Mattermost\CommandService;

use App\Contracts\Mattermost\CommandServiceContract;
use App\Exceptions\Mattermost\ServiceException;
use App\Traits\Mattermost\CallEndpointMethod;
use Arsentiyz\MattermostDriver\Collections\CommandCollection;
use Arsentiyz\MattermostDriver\Endpoints\CommandEndpoint;
use Arsentiyz\MattermostDriver\Entities\Command;
use Arsentiyz\MattermostDriver\Requests\Command\CreateRequest;
use Arsentiyz\MattermostDriver\Requests\Command\IndexRequest;
use Arsentiyz\MattermostDriver\Requests\Command\UpdateRequest;
use Arsentiyz\MattermostDriver\Responses\Command\CreateResponse;
use Arsentiyz\MattermostDriver\Responses\Command\DeleteResponse;
use Arsentiyz\MattermostDriver\Responses\Command\IndexResponse;
use Arsentiyz\MattermostDriver\Responses\Command\ShowResponse;
use Arsentiyz\MattermostDriver\Responses\Command\UpdateResponse;

final class Service implements CommandServiceContract
{
    use CallEndpointMethod;

    public function __construct(
        private CommandEndpoint $endpoint,
    ) {
    }

    /**
     * @throws ServiceException
     */
    public function getCommands(IndexRequest $request): CommandCollection
    {
        /** @var IndexResponse $response */
        $response = $this->call(fn (): IndexResponse => $this->endpoint->index($request));

        return $response->getCommands();
    }

    /**
     * @throws ServiceException
     */
    public function createCommand(CreateRequest $request): Command
    {
        /** @var CreateResponse $response */
        $response = $this->call(fn (): CreateResponse => $this->endpoint->create($request));

        return $response->getCommand();
    }

    /**
     * @throws ServiceException
     */
    public function updateCommand(UpdateRequest $request): Command
    {
        /** @var UpdateResponse $response */
        $response = $this->call(fn (): UpdateResponse => $this->endpoint->update($request));

        return $response->getCommand();
    }

    /**
     * @throws ServiceException
     */
    public function deleteCommand(string $commandId): void
    {
        $this->call(fn (): DeleteResponse => $this->endpoint->delete($commandId));
    }

    /**
     * @throws ServiceException
     */
    public function showCommand(string $commandId): Command
    {
        /** @var ShowResponse $response */
        $response = $this->call(fn (): ShowResponse => $this->endpoint->show($commandId));

        return $response->getCommand();
    }
}
