<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mattermost\CommandResource\Pages;

use App\Console\Commands\Mattermost\SyncCommandCommand;
use App\Filament\Resources\Mattermost\CommandResource;
use App\Filament\Resources\Mattermost\CommandResource\Strategies\DeleteStrategy;
use App\Filament\Resources\Mattermost\CommandResource\Strategies\EditStrategy;
use App\Models\Mattermost\Command;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

final class EditCommand extends EditRecord
{
    protected static string $resource = CommandResource::class;

    /**
     * @return array<int, Action>|array<int, ActionGroup>
     */
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->requiresConfirmation()->before(DeleteStrategy::make()),
            Action::make('sync')
                ->label(__('filament::resources/pages/form-element.sync_action'))
                ->disabled(fn (Command $record): bool => null === $record->external_id)
                ->successNotification(
                    Notification::make()
                        ->title(__('filament::resources/pages/form-element.sync_success'))
                        ->success()
                )
                ->action(function (Command $record): void {
                    Artisan::call(SyncCommandCommand::class, [
                        'external_id' => $record->external_id,
                    ]);

                    $this->redirect(self::getUrl(['record' => $record->id]));
                }),
        ];
    }

    /**
     * @param Command $record
     * @param array<string, mixed> $data
     * @throws BindingResolutionException
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $data = EditStrategy::make($record, $data);

        return parent::handleRecordUpdate($record, $data);
    }
}
