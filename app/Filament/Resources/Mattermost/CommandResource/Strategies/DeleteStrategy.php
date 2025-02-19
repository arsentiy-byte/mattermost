<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mattermost\CommandResource\Strategies;

use App\Contracts\Mattermost\CommandServiceContract;
use App\Models\Mattermost\Command;
use Closure;
use Illuminate\Support\Facades\App;

final class DeleteStrategy
{
    public static function make(): Closure
    {
        return static function (Command $command): void {
            /** @var CommandServiceContract $service */
            $service = App::make(CommandServiceContract::class);

            $service->deleteCommand($command->external_id);
        };
    }
}
