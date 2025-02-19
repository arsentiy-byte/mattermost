<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mattermost\ChannelResource\Pages;

use App\Filament\Resources\Mattermost\ChannelResource;
use Filament\Resources\Pages\ViewRecord;

final class ViewChannel extends ViewRecord
{
    protected static string $resource = ChannelResource::class;
}
