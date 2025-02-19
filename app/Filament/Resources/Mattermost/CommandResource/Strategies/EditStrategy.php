<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mattermost\CommandResource\Strategies;

use App\Contracts\Mattermost\CommandServiceContract;
use App\Models\Mattermost\Command;
use App\Traits\ConfigTrait;
use Arsentiyz\MattermostDriver\Enums\Command\Method;
use Arsentiyz\MattermostDriver\Requests\Command\UpdateRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

final class EditStrategy
{
    use ConfigTrait;

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     * @throws BindingResolutionException
     */
    public static function make(Command $record, array $data): array
    {
        $trigger = Arr::get($data, 'trigger');
        $username = Arr::get($data, 'username');
        $iconUrl = Arr::get($data, 'icon_url');

        if (Str::contains($trigger, '@wall-e', true)) {
            $username = self::getWalleUsername();
            $iconUrl = self::getWalleIconUrl();
        }

        if (Str::contains($trigger, '@alfred', true)) {
            $username = self::getAlfredUsername();
            $iconUrl = self::getAlfredIconUrl();
        }

        /** @var CommandServiceContract $service */
        $service = App::make(CommandServiceContract::class);

        $commandEntity = $service
            ->updateCommand(new UpdateRequest(
                $record->external_id,
                $record->token,
                $record->create_at?->toImmutable(),
                $record->update_at?->toImmutable(),
                $record->delete_at?->toImmutable(),
                $record->creator_id,
                $record->team_id,
                $trigger,
                Method::from(Arr::get($data, 'method')),
                $username,
                $iconUrl,
                (bool)Arr::get($data, 'auto_complete', false),
                Arr::get($data, 'auto_complete_desc'),
                Arr::get($data, 'auto_complete_hint'),
                Arr::get($data, 'display_name'),
                Arr::get($data, 'description'),
                Arr::get($data, 'url'),
            ));

        Arr::set($data, 'create_at', $commandEntity->createAt?->toImmutable());
        Arr::set($data, 'update_at', $commandEntity->updateAt?->toImmutable());
        Arr::set($data, 'delete_at', $commandEntity->deleteAt?->toImmutable());

        return $data;
    }
}
