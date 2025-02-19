<?php

declare(strict_types=1);

namespace App\Handlers\Mattermost;

use App\Contracts\Mattermost\CommandServiceContract;
use App\Models\Mattermost\Command;
use App\Models\Mattermost\Team;
use Arsentiyz\MattermostDriver\Entities\Command as CommandEntity;
use Arsentiyz\MattermostDriver\Requests\Command\IndexRequest;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class SyncCommandsHandler
{
    public function __construct(
        private CommandServiceContract $service,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        $service = $this->service;

        DB::transaction(static function () use ($service): void {
            Command::query()->delete();

            Team::query()
                ->get()
                ->each(function (Team $team) use ($service): void {
                    $service
                        ->getCommands(new IndexRequest($team->id, true))
                        ->each(function (CommandEntity $entity): void {
                            Command::query()->updateOrCreate([
                                'external_id' => $entity->id,
                            ], [
                                'token' => $entity->token,
                                'create_at' => $entity->createAt,
                                'update_at' => $entity->updateAt,
                                'delete_at' => $entity->deleteAt,
                                'creator_id' => $entity->creatorId,
                                'team_id' => $entity->teamId,
                                'trigger' => $entity->trigger,
                                'method' => $entity->method,
                                'username' => $entity->username,
                                'icon_url' => $entity->iconUrl,
                                'auto_complete' => $entity->autoComplete,
                                'auto_complete_desc' => $entity->autoCompleteDesc,
                                'auto_complete_hint' => $entity->autoCompleteHint,
                                'display_name' => $entity->displayName,
                                'description' => $entity->description,
                                'url' => $entity->url,
                            ]);
                        });
                });
        });
    }
}
