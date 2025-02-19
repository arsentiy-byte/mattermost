<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mattermost\CommandResource\Strategies;

use App\Contracts\Mattermost\CommandServiceContract;
use Arsentiyz\MattermostDriver\Enums\Command\Method;
use Arsentiyz\MattermostDriver\Requests\Command\CreateRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

final class CreateStrategy
{
    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     * @throws BindingResolutionException
     */
    public static function make(array $data): array
    {
        /** @var CommandServiceContract $service */
        $service = App::make(CommandServiceContract::class);

        $commandEntity = $service
            ->createCommand(new CreateRequest(
                Arr::get($data, 'team_id'),
                Method::from(Arr::get($data, 'method')),
                Arr::get($data, 'trigger'),
                Arr::get($data, 'url'),
            ));

        Arr::set($data, 'external_id', $commandEntity->id);
        Arr::set($data, 'token', $commandEntity->token);
        Arr::set($data, 'create_at', $commandEntity->createAt?->toImmutable());
        Arr::set($data, 'update_at', $commandEntity->updateAt?->toImmutable());
        Arr::set($data, 'delete_at', $commandEntity->deleteAt?->toImmutable());
        Arr::set($data, 'creator_id', $commandEntity->creatorId);
        Arr::set($data, 'username', $commandEntity->username);
        Arr::set($data, 'icon_url', $commandEntity->iconUrl);
        Arr::set($data, 'auto_complete', $commandEntity->autoComplete);
        Arr::set($data, 'auto_complete_desc', $commandEntity->autoCompleteDesc);
        Arr::set($data, 'auto_complete_hint', $commandEntity->autoCompleteHint);
        Arr::set($data, 'display_name', $commandEntity->displayName);
        Arr::set($data, 'description', $commandEntity->description);

        return $data;
    }
}
