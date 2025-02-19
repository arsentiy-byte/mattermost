<?php

declare(strict_types=1);

namespace App\Services\Mattermost\PostService;

use App\Contracts\Mattermost\AlfredPostServiceContract;
use App\Contracts\Mattermost\WallePostServiceContract;
use App\Exceptions\Mattermost\ServiceException;
use App\Traits\Mattermost\CallEndpointMethod;
use Arsentiyz\MattermostDriver\Endpoints\PostEndpoint;
use Arsentiyz\MattermostDriver\Entities\Post;
use Arsentiyz\MattermostDriver\Requests\Post\CreateRequest;
use Arsentiyz\MattermostDriver\Requests\Post\UpdateRequest;
use Arsentiyz\MattermostDriver\Responses\Post\CreateResponse;
use Arsentiyz\MattermostDriver\Responses\Post\UpdateResponse;

final readonly class Service implements WallePostServiceContract, AlfredPostServiceContract
{
    use CallEndpointMethod;

    public function __construct(
        private PostEndpoint $endpoint,
    ) {
    }

    /**
     * @throws ServiceException
     */
    public function createPost(CreateRequest $request): Post
    {
        /** @var CreateResponse $response */
        $response = $this->call(fn (): CreateResponse => $this->endpoint->create($request));

        return $response->getPost();
    }

    /**
     * @throws ServiceException
     */
    public function updatePost(UpdateRequest $request): Post
    {
        /** @var UpdateResponse $response */
        $response = $this->call(fn (): UpdateResponse => $this->endpoint->update($request));

        return $response->getPost();
    }
}
