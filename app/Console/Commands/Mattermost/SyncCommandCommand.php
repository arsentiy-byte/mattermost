<?php

declare(strict_types=1);

namespace App\Console\Commands\Mattermost;

use App\Handlers\Mattermost\SyncCommandHandler;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;
use Illuminate\Contracts\Console\PromptsForMissingInput;

final class SyncCommandCommand extends Command implements Isolatable, PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mattermost:sync-command {external_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize Mattermost command with the database.';

    /**
     * Execute the console command.
     */
    public function handle(SyncCommandHandler $handler): void
    {
        $handler->handle($this->argument('external_id'));
    }

    public function isolatableId(): string
    {
        return $this->argument('external_id');
    }

    /**
     * @return array<string, string>
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'external_id' => 'Enter external_id of the command:',
        ];
    }
}
