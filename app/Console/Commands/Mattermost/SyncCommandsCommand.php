<?php

declare(strict_types=1);

namespace App\Console\Commands\Mattermost;

use App\Handlers\Mattermost\SyncCommandsHandler;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;

final class SyncCommandsCommand extends Command implements Isolatable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mattermost:sync-commands';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize Mattermost commands with the database.';

    /**
     * Execute the console command.
     */
    public function handle(SyncCommandsHandler $handler): void
    {
        $handler->handle();
    }
}
