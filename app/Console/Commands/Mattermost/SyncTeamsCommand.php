<?php

declare(strict_types=1);

namespace App\Console\Commands\Mattermost;

use App\Handlers\Mattermost\SyncTeamsHandler;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;

final class SyncTeamsCommand extends Command implements Isolatable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mattermost:sync-teams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize Mattermost teams with the database.';

    /**
     * Execute the console command.
     */
    public function handle(SyncTeamsHandler $handler): void
    {
        $handler->handle();
    }
}
