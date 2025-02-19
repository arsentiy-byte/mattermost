<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mattermost\CommandResource\Pages;

use App\Filament\Resources\Mattermost\CommandResource;
use App\Filament\Resources\Mattermost\CommandResource\Strategies\CreateStrategy;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;

final class CreateCommand extends CreateRecord
{
    protected static string $resource = CommandResource::class;

    /**
     * @param array<string, mixed> $data
     * @throws BindingResolutionException
     */
    protected function handleRecordCreation(array $data): Model
    {
        $data = CreateStrategy::make($data);

        return parent::handleRecordCreation($data);
    }
}
