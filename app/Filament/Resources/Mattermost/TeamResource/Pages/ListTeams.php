<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mattermost\TeamResource\Pages;

use App\Filament\Resources\Mattermost\TeamResource;
use Filament\Resources\Pages\ListRecords;

final class ListTeams extends ListRecords
{
    protected static string $resource = TeamResource::class;
}
