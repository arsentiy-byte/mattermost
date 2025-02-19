<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mattermost\ChannelResource\Pages;

use App\Filament\Resources\Mattermost\ChannelResource;
use Filament\Resources\Pages\ListRecords;

final class ListChannels extends ListRecords
{
    protected static string $resource = ChannelResource::class;
}
