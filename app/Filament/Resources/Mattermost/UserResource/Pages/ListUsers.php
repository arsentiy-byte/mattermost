<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mattermost\UserResource\Pages;

use App\Filament\Resources\Mattermost\UserResource;
use Filament\Resources\Pages\ListRecords;

final class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
}
