<?php

declare(strict_types=1);

namespace App\Handlers\Mattermost;

use App\Contracts\Mattermost\UserServiceContract;
use App\Models\Mattermost\Team;
use App\Models\Mattermost\User;
use App\Traits\ConfigTrait;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class SyncUsersHandler
{
    use ConfigTrait;

    public function __construct(
        private UserServiceContract $service
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        $service = $this->service;

        DB::transaction(static function () use ($service): void {
            Team::query()
                ->with(['users'])
                ->get()
                ->each(function (Team $team) use ($service): void {
                    $users = $service
                        ->all(inTeamId: $team->id)
                        ->keyBy('id');

                    $team
                        ->users
                        /** @phpstan-ignore-next-line */
                        ->each(function (User $user) use ($team, $users): void {
                            if ( ! $users->has($user->id)) {
                                $team->users()->detach($user->id);
                            }
                        });

                    foreach ($users as $user) {
                        $createdUser = User::query()->updateOrCreate([
                            'id' => $user->id,
                        ], [
                            'username' => $user->username,
                            'first_name' => $user->firstName,
                            'last_name' => $user->lastName,
                            'nickname' => $user->nickname,
                            'email' => $user->email,
                        ]);

                        if ($createdUser->teams()->where('team_id', $team->id)->doesntExist()) {
                            $createdUser->teams()->attach($team->id);
                        }
                    }
                });
        });
    }
}
