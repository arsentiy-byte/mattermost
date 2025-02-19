<?php

declare(strict_types=1);

use App\Console\Commands\Mattermost\SyncChannelsCommand;
use App\Console\Commands\Mattermost\SyncCommandsCommand;
use App\Console\Commands\Mattermost\SyncTeamsCommand;
use App\Console\Commands\Mattermost\SyncUsersCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function (): void {
    /** @phpstan-ignore-next-line */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command(SyncTeamsCommand::class)->daily();
Schedule::command(SyncChannelsCommand::class)->daily();
Schedule::command(SyncCommandsCommand::class)->daily();
Schedule::command(SyncUsersCommand::class)->daily();
