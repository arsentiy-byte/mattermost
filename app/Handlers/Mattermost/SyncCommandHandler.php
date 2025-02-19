<?php

declare(strict_types=1);

namespace App\Handlers\Mattermost;

use App\Contracts\Mattermost\CommandServiceContract;
use App\Models\Mattermost\Command;

final readonly class SyncCommandHandler
{
    public function __construct(
        private CommandServiceContract $service,
    ) {
    }

    public function handle(string $externalId): void
    {
        $commandEntity = $this->service->showCommand($externalId);

        Command::query()->updateOrCreate([
            'external_id' => $commandEntity->id,
        ], [
            'token' => $commandEntity->token,
            'create_at' => $commandEntity->createAt?->getTimestamp(),
            'update_at' => $commandEntity->updateAt?->getTimestamp(),
            'delete_at' => $commandEntity->deleteAt?->getTimestamp(),
            'creator_id' => $commandEntity->creatorId,
            'team_id' => $commandEntity->teamId,
            'trigger' => $commandEntity->trigger,
            'method' => $commandEntity->method,
            'username' => $commandEntity->username,
            'icon_url' => $commandEntity->iconUrl,
            'auto_complete' => $commandEntity->autoComplete,
            'auto_complete_desc' => $commandEntity->autoCompleteDesc,
            'auto_complete_hint' => $commandEntity->autoCompleteHint,
            'display_name' => $commandEntity->displayName,
            'description' => $commandEntity->description,
            'url' => $commandEntity->url,
        ]);
    }
}
