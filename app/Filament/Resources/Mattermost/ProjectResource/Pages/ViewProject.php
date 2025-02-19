<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mattermost\ProjectResource\Pages;

use App\Filament\Resources\Mattermost\ProjectResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewProject extends ViewRecord
{
    protected static string $resource = ProjectResource::class;

    /**
     * @return array<int, Action>|array<int, ActionGroup>
     */
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->requiresConfirmation(),
        ];
    }
}
