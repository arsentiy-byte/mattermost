<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mattermost;

use App\Console\Commands\Mattermost\SyncUsersCommand;
use App\Filament\Resources\Mattermost\UserResource\Pages\ListUsers;
use App\Filament\Resources\Mattermost\UserResource\Pages\ViewUser;
use App\Models\Mattermost\User;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Artisan;

final class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationGroup(): ?string
    {
        return __('filament::layout.menu.mattermost');
    }

    public static function getLabel(): ?string
    {
        return __('filament::resources/mattermost/user.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament::resources/mattermost/user.plural_title');
    }

    public static function getPluralLabel(): ?string
    {
        return __('filament::resources/mattermost/user.plural_title');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->schema([
                        TextEntry::make('id')
                            ->label(__('filament::resources/pages/form-element.user_id')),
                        TextEntry::make('username')
                            ->label(__('filament::resources/pages/form-element.username')),
                        TextEntry::make('first_name')
                            ->label(__('filament::resources/pages/form-element.first_name')),
                        TextEntry::make('last_name')
                            ->label(__('filament::resources/pages/form-element.last_name')),
                        TextEntry::make('nickname')
                            ->label(__('filament::resources/pages/form-element.nickname')),
                        TextEntry::make('email')
                            ->label(__('filament::resources/pages/form-element.email')),
                        TextEntry::make('teams.display_name')
                            ->label(__('filament::resources/pages/form-element.team')),
                        TextEntry::make('created_at')
                            ->label(__('filament::resources/pages/form-element.created_at')),
                        TextEntry::make('updated_at')
                            ->label(__('filament::resources/pages/form-element.updated_at')),
                    ])
                    ->columns([
                        'sm' => 2,
                    ])
                    ->columnSpan([
                        'sm' => 2,
                    ]),
            ]);
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'view' => ViewUser::route('/{record}'),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('filament::resources/pages/form-element.user_id'))
                    ->badge(),
                TextColumn::make('username')
                    ->searchable()
                    ->label(__('filament::resources/pages/form-element.username')),
                TextColumn::make('full_name')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where(function (Builder $query) use ($search): Builder {
                                /** @phpstan-ignore-next-line */
                                return $query
                                    ->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", [sprintf('%%%s%%', $search)])
                                    ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", [sprintf('%%%s%%', $search)]);
                            });
                    })
                    ->label(__('filament::resources/pages/form-element.full_name')),
                TextColumn::make('teams.display_name')
                    ->wrap()
                    ->searchable()
                    ->label(__('filament::resources/pages/form-element.team')),
                TextColumn::make('email')
                    ->searchable()
                    ->label(__('filament::resources/pages/form-element.email')),
                TextColumn::make('nickname')
                    ->searchable()
                    ->label(__('filament::resources/pages/form-element.nickname')),
                TextColumn::make('created_at')
                    ->label(__('filament::resources/pages/form-element.date')),
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->headerActions([
                Action::make('sync')
                    ->label(__('filament::resources/pages/form-element.sync_action'))
                    ->successNotification(
                        Notification::make()
                            ->title(__('filament::resources/pages/form-element.sync_success'))
                            ->success()
                    )
                    ->requiresConfirmation()
                    ->action(fn (): int => Artisan::call(SyncUsersCommand::class)),
            ])
            /** @phpstan-ignore-next-line */
            ->query(User::query()->with(['teams' => fn (BelongsToMany $query) => $query->select(['mattermost_teams.id', 'mattermost_teams.display_name'])]));
    }
}
