<?php

declare(strict_types=1);

namespace App\Contracts\Mattermost;

use Arsentiyz\MattermostDriver\Collections\UserCollection;
use Arsentiyz\MattermostDriver\Requests\User\IndexRequest;

interface UserServiceContract
{
    public function index(IndexRequest $request): UserCollection;

    public function all(?string $inTeamId = null, ?string $notInTeamId = null): UserCollection;
}
