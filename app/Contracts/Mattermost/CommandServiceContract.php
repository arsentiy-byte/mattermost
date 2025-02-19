<?php

declare(strict_types=1);

namespace App\Contracts\Mattermost;

use Arsentiyz\MattermostDriver\Collections\CommandCollection;
use Arsentiyz\MattermostDriver\Entities\Command;
use Arsentiyz\MattermostDriver\Requests\Command\CreateRequest;
use Arsentiyz\MattermostDriver\Requests\Command\IndexRequest;
use Arsentiyz\MattermostDriver\Requests\Command\UpdateRequest;

interface CommandServiceContract
{
    public function getCommands(IndexRequest $request): CommandCollection;

    public function createCommand(CreateRequest $request): Command;

    public function updateCommand(UpdateRequest $request): Command;

    public function deleteCommand(string $commandId): void;

    public function showCommand(string $commandId): Command;
}
