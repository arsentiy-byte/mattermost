<?php

declare(strict_types=1);

namespace App\Console\Commands\Mattermost;

use App\Handlers\Mattermost\SyncChannelsHandler;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;

final class SyncChannelsCommand extends Command implements Isolatable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mattermost:sync-channels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize Mattermost channels with the database.';

    /**
     * Execute the console command.
     */
    public function handle(SyncChannelsHandler $handler): void
    {
        $handler->handle();
    }
}
