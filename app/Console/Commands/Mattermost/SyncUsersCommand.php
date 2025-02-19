<?php

declare(strict_types=1);

namespace App\Console\Commands\Mattermost;

use App\Handlers\Mattermost\SyncUsersHandler;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;
use Throwable;

final class SyncUsersCommand extends Command implements Isolatable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mattermost:sync-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize Mattermost users with the database.';

    /**
     * Execute the console command.
     * @throws Throwable
     */
    public function handle(SyncUsersHandler $handler): void
    {
        $handler->handle();
    }
}
