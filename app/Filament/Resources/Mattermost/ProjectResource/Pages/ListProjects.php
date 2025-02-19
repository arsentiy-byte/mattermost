<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mattermost\ProjectResource\Pages;

use App\Filament\Resources\Mattermost\ProjectResource;
use Filament\Resources\Pages\ListRecords;

final class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;
}
