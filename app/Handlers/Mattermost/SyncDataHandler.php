<?php

declare(strict_types=1);

namespace App\Handlers\Mattermost;

use App\Models\Mattermost\Channel;
use App\Models\Mattermost\Team;
use App\Models\Mattermost\User;
use Arsentiyz\MattermostDriver\DTO\CommandRequestDTO;
use Throwable;

final readonly class SyncDataHandler
{
    public function __construct(
        private SyncTeamsHandler    $teamsHandler,
        private SyncChannelsHandler $channelsHandler,
        private SyncUsersHandler    $usersHandler,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(CommandRequestDTO $dto): void
    {
        if (Team::query()->where('id', $dto->teamId)->doesntExist()) {
            $this->teamsHandler->handle();
        }

        if (Channel::query()->where('id', $dto->channelId)->doesntExist()) {
            $this->channelsHandler->handle();
        }

        if (User::query()->where('id', $dto->userId)->doesntExist()) {
            $this->usersHandler->handle();
        }
    }
}
