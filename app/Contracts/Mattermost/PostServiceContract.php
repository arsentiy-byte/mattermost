<?php

declare(strict_types=1);

namespace App\Contracts\Mattermost;

use Arsentiyz\MattermostDriver\Entities\Post;
use Arsentiyz\MattermostDriver\Requests\Post\CreateRequest;
use Arsentiyz\MattermostDriver\Requests\Post\UpdateRequest;

interface PostServiceContract
{
    public function createPost(CreateRequest $request): Post;
    public function updatePost(UpdateRequest $request): Post;
}
