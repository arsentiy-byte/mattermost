<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mattermost;

use App\Console\Commands\Mattermost\SyncCommandsCommand;
use App\Filament\Resources\Mattermost\CommandResource\Pages\CreateCommand;
use App\Filament\Resources\Mattermost\CommandResource\Pages\EditCommand;
use App\Filament\Resources\Mattermost\CommandResource\Pages\ListCommands;
use App\Filament\Resources\Mattermost\CommandResource\Strategies\DeleteStrategy;
use App\Models\Mattermost\Command;
use App\Traits\ConfigTrait;
use Arsentiyz\MattermostDriver\Enums\Command\Method;
use Filament\Forms\Components\Section as FormSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;

final class CommandResource extends Resource
{
    use ConfigTrait;

    protected static ?string $model = Command::class;

    protected static ?string $navigationIcon = 'heroicon-o-command-line';

    public static function getNavigationGroup(): ?string
    {
        return __('filament::layout.menu.mattermost');
    }

    public static function getLabel(): ?string
    {
        return __('filament::resources/mattermost/command.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament::resources/mattermost/command.plural_title');
    }

    public static function getPluralLabel(): ?string
    {
        return __('filament::resources/mattermost/command.plural_title');
    }

    public static function form(Form $form): Form
    {
        return match ($form->getOperation()) {
            'edit', 'view' => self::getEditForm($form),
            default => self::getCreateForm($form),
        };
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListCommands::route('/'),
            'create' => CreateCommand::route('/create'),
            'edit' => EditCommand::route('/{record}'),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('external_id')
                    ->label(__('filament::resources/pages/form-element.command_id')),
                TextColumn::make('trigger')
                    ->label(__('filament::resources/pages/form-element.trigger')),
                TextColumn::make('display_name')
                    ->label(__('filament::resources/pages/form-element.display_name')),
                TextColumn::make('team.display_name')
                    ->label(__('filament::resources/pages/form-element.team'))
                    ->badge()
                    ->url(fn (Command $record) => TeamResource::getUrl('view', ['record' => $record->team_id])),
                TextColumn::make('created_at')
                    ->label(__('filament::resources/pages/form-element.date')),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()->requiresConfirmation()->before(DeleteStrategy::make()),
            ])
            ->headerActions([
                CreateAction::make(),
                Action::make('sync')
                    ->label(__('filament::resources/pages/form-element.sync_action'))
                    ->successNotification(
                        Notification::make()
                            ->title(__('filament::resources/pages/form-element.sync_success'))
                            ->success()
                    )
                    ->requiresConfirmation()
                    ->action(fn (): int => Artisan::call(SyncCommandsCommand::class)),
            ]);
    }

    protected static function getEditForm(Form $form): Form
    {
        return $form
            ->schema([
                FormSection::make()
                    ->schema([
                        TextInput::make('id')
                            ->label(__('filament::resources/pages/form-element.command_id'))
                            ->disabled(),
                        TextInput::make('external_id')
                            ->label(__('filament::resources/pages/form-element.external_id'))
                            ->disabled(),
                        TextInput::make('token')
                            ->label(__('filament::resources/pages/form-element.token'))
                            ->disabled(),
                        TextInput::make('creator_id')
                            ->label(__('filament::resources/pages/form-element.creator_id'))
                            ->disabled(),
                        TextInput::make('team')
                            ->formatStateUsing(fn (Command $record): string => $record->team->display_name)
                            ->label(__('filament::resources/pages/form-element.team'))
                            ->disabled(),
                        TextInput::make('created_at')
                            ->label(__('filament::resources/pages/form-element.created_at'))
                            ->formatStateUsing(fn (Command $record): string => $record->created_at->toDateTimeString())
                            ->disabled(),
                        TextInput::make('updated_at')
                            ->label(__('filament::resources/pages/form-element.updated_at'))
                            ->formatStateUsing(fn (Command $record): string => $record->updated_at->toDateTimeString())
                            ->disabled(),
                    ]),
                FormSection::make()
                    ->schema([
                        TextInput::make('display_name')
                            ->label(__('filament::resources/pages/form-element.display_name'))
                            ->required(),
                        TextInput::make('description')
                            ->label(__('filament::resources/pages/form-element.description'))
                            ->required(),
                        TextInput::make('trigger')
                            ->label(__('filament::resources/pages/form-element.trigger'))
                            ->required(),
                        Select::make('method')
                            ->label(__('filament::resources/pages/form-element.method'))
                            ->options(Arr::mapWithKeys(Method::cases(), static fn (Method $method): array => [$method->value => $method->name]))
                            ->required(),
                        TextInput::make('username')
                            ->label(__('filament::resources/pages/form-element.response_username'))
                            ->disabled(),
                        TextInput::make('icon_url')
                            ->label(__('filament::resources/pages/form-element.icon_url'))
                            ->disabled(),
                        Toggle::make('auto_complete')
                            ->label(__('filament::resources/pages/form-element.auto_complete'))
                            ->live(),
                        TextInput::make('auto_complete_desc')
                            ->label(__('filament::resources/pages/form-element.auto_complete_desc'))
                            ->visible(fn (Get $get): bool => $get('auto_complete')),
                        TextInput::make('auto_complete_hint')
                            ->label(__('filament::resources/pages/form-element.auto_complete_hint'))
                            ->visible(fn (Get $get): bool => $get('auto_complete')),
                        TextInput::make('url')
                            ->label(__('filament::resources/pages/form-element.url'))
                            ->required(),
                    ]),
            ]);
    }

    protected static function getCreateForm(Form $form): Form
    {
        return $form
            ->schema([
                FormSection::make()
                    ->schema([
                        Select::make('team_id')
                            ->relationship('team', 'display_name')
                            ->required(),
                        TextInput::make('trigger')
                            ->label(__('filament::resources/pages/form-element.trigger'))
                            ->required(),
                        Select::make('method')
                            ->label(__('filament::resources/pages/form-element.method'))
                            ->options(Arr::mapWithKeys(Method::cases(), static fn (Method $method): array => [$method->value => $method->name]))
                            ->required(),
                        TextInput::make('url')
                            ->label(__('filament::resources/pages/form-element.url'))
                            ->default(self::getMattermostCommandHook())
                            ->required(),
                    ]),
            ]);
    }
}
