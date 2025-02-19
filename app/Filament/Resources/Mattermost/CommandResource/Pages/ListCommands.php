<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mattermost\CommandResource\Pages;

use App\Filament\Resources\Mattermost\CommandResource;
use Filament\Resources\Pages\ListRecords;

final class ListCommands extends ListRecords
{
    protected static string $resource = CommandResource::class;
}
