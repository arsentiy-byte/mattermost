<?php

declare(strict_types=1);

namespace App\Handlers\Mattermost;

use App\Contracts\Mattermost\TeamServiceContract;
use App\Models\Mattermost\Team;
use App\Traits\ConfigTrait;
use Arsentiyz\MattermostDriver\Requests\Team\IndexRequest;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class SyncTeamsHandler
{
    use ConfigTrait;

    private bool $enabled;

    public function __construct(
        private TeamServiceContract $service
    ) {
        $this->enabled = (bool)config('mattermost.sync_teams_enabled', true);
    }

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        if (false === $this->enabled) {
            return;
        }

        $service = $this->service;

        DB::transaction(static function () use ($service): void {
            $teams = $service
                ->getTeams(new IndexRequest())
                ->keyBy('id');

            Team::query()
                ->get()
                ->each(function (Team $team) use ($teams): void {
                    if ( ! $teams->has($team->id)) {
                        $team->delete();
                    }
                });

            foreach ($teams as $team) {
                Team::query()->updateOrCreate([
                    'id' => $team->id,
                ], [
                    'name' => $team->name,
                    'display_name' => $team->displayName,
                ]);
            }
        });
    }
}
