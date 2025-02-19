<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mattermost;

use App\Console\Commands\Mattermost\SyncChannelsCommand;
use App\Filament\Resources\Mattermost\ChannelResource\Pages\ListChannels;
use App\Filament\Resources\Mattermost\ChannelResource\Pages\ViewChannel;
use App\Models\Mattermost\Channel;
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
use Illuminate\Support\Facades\Artisan;

final class ChannelResource extends Resource
{
    protected static ?string $model = Channel::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    public static function getNavigationGroup(): ?string
    {
        return __('filament::layout.menu.mattermost');
    }

    public static function getLabel(): ?string
    {
        return __('filament::resources/mattermost/channel.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament::resources/mattermost/channel.plural_title');
    }

    public static function getPluralLabel(): ?string
    {
        return __('filament::resources/mattermost/channel.plural_title');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->schema([
                        TextEntry::make('id')
                            ->label(__('filament::resources/pages/form-element.chat_id')),
                        TextEntry::make('name')
                            ->label(__('filament::resources/pages/form-element.chat_name')),
                        TextEntry::make('display_name')
                            ->label(__('filament::resources/pages/form-element.display_name')),
                        TextEntry::make('team.display_name')
                            ->label(__('filament::resources/pages/form-element.team'))
                            ->badge()
                            ->url(fn (Channel $record) => TeamResource::getUrl('view', ['record' => $record->team_id])),
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
            'index' => ListChannels::route('/'),
            'view' => ViewChannel::route('/{record}'),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('filament::resources/pages/form-element.chat_id'))
                    ->badge(),
                TextColumn::make('name')
                    ->label(__('filament::resources/pages/form-element.chat_name')),
                TextColumn::make('display_name')
                    ->label(__('filament::resources/pages/form-element.display_name')),
                TextColumn::make('team.display_name')
                    ->label(__('filament::resources/pages/form-element.team'))
                    ->badge()
                    ->url(fn (Channel $record) => TeamResource::getUrl('view', ['record' => $record->team_id])),
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
                    ->action(fn (): int => Artisan::call(SyncChannelsCommand::class)),
            ]);
    }
}
