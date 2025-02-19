<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mattermost;

use App\Filament\Resources\Mattermost\ProjectResource\Pages\ListProjects;
use App\Filament\Resources\Mattermost\ProjectResource\Pages\ViewProject;
use App\Models\Mattermost\ChannelProject;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class ProjectResource extends Resource
{
    protected static ?string $model = ChannelProject::class;

    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';

    public static function getNavigationGroup(): ?string
    {
        return __('filament::layout.menu.mattermost');
    }

    public static function getLabel(): ?string
    {
        return __('filament::resources/mattermost/project.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament::resources/mattermost/project.plural_title');
    }

    public static function getPluralLabel(): ?string
    {
        return __('filament::resources/mattermost/project.plural_title');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->schema([
                        TextEntry::make('id')
                            ->label(__('filament::resources/pages/form-element.project_id')),
                        TextEntry::make('project')
                            ->label(__('filament::resources/pages/form-element.project')),
                        TextEntry::make('channel.display_name')
                            ->label(__('filament::resources/pages/form-element.chat'))
                            ->badge()
                            ->url(fn (ChannelProject $record) => ChannelResource::getUrl('view', ['record' => $record->channel_id])),
                        IconEntry::make('workflow_enabled')
                            ->label(__('filament::resources/pages/form-element.workflow_enabled'))
                            ->boolean(),
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
            'index' => ListProjects::route('/'),
            'view' => ViewProject::route('/{record}'),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('filament::resources/pages/form-element.project_id'))
                    ->badge(),
                TextColumn::make('project')
                    ->label(__('filament::resources/pages/form-element.project')),
                TextColumn::make('channel.display_name')
                    ->label(__('filament::resources/pages/form-element.chat'))
                    ->badge()
                    ->url(fn (ChannelProject $record) => ChannelResource::getUrl('view', ['record' => $record->channel_id])),
                CheckboxColumn::make('workflow_enabled')
                    ->label(__('filament::resources/pages/form-element.workflow_enabled')),
                TextColumn::make('created_at')
                    ->label(__('filament::resources/pages/form-element.date')),
            ])
            ->actions([
                ViewAction::make(),
                DeleteAction::make()->requiresConfirmation(),
            ]);
    }
}
