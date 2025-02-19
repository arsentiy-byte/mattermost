<?php

declare(strict_types=1);

namespace App\Handlers\Mattermost;

use App\Contracts\Mattermost\TeamServiceContract;
use App\Models\Mattermost\Channel;
use App\Models\Mattermost\Team;
use Arsentiyz\MattermostDriver\Collections\ChannelCollection;
use Arsentiyz\MattermostDriver\Entities\Channel as ChannelEntity;
use Arsentiyz\MattermostDriver\Requests\Team\ChannelsRequest;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class SyncChannelsHandler
{
    public function __construct(
        private TeamServiceContract $service,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        DB::transaction(function (): void {
            Team::query()
                ->with(['channels'])
                ->get()
                ->each(function (Team $team): void {
                    $publicChannels = $this->getPublicChannels($team->id);
                    $privateChannels = $this->getPrivateChannels($team->id);

                    $channels = $publicChannels->merge($privateChannels);

                    $diff = $team
                        ->channels
                        ->whereNotIn('id', $channels->pluck('id'))
                        ->pluck('id');

                    Channel::query()
                        ->whereIn('id', $diff)
                        ->delete();

                    $channels->each(function (ChannelEntity $entity): void {
                        Channel::query()
                            ->updateOrCreate([
                                'id' => $entity->id,
                            ], [
                                'team_id' => $entity->teamId,
                                'name' => $entity->name,
                                'display_name' => $entity->displayName,
                            ]);
                    });
                });
        });
    }

    private function getPublicChannels(string $teamId): ChannelCollection
    {
        $publicChannels = new ChannelCollection();

        $page = 0;
        do {
            $publicChannelsFromResponse = $this->service->getPublicChannels(new ChannelsRequest($teamId, $page++));

            $publicChannels = $publicChannels->merge($publicChannelsFromResponse);
        } while ($publicChannelsFromResponse->isNotEmpty());

        return $publicChannels;
    }

    private function getPrivateChannels(string $teamId): ChannelCollection
    {
        $privateChannels = new ChannelCollection();

        $page = 0;
        do {
            $privateChannelsFromResponse = $this->service->getPrivateChannels(new ChannelsRequest($teamId, $page++));

            $privateChannels = $privateChannels->merge($privateChannelsFromResponse);
        } while ($privateChannelsFromResponse->isNotEmpty());

        return $privateChannels;
    }
}
