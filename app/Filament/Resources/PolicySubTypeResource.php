<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PolicySubTypeResource\Pages;
use App\Models\PolicySubType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PolicySubTypeResource extends Resource
{
    protected static ?string $model = PolicySubType::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-on-square-stack';

    public static function getNavigationGroup(): ?string
    {
        return \App\Enums\NavigationGroup::SYSTEM_CONFIGURATION->label();
    }

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('messages.policy_sub_type.name'))
                    ->placeholder(__('messages.policy_sub_type.name'))
                    ->maxLength(255)
                    ->required(),
                Select::make('policy_type_id')
                    ->label(__('messages.policy_sub_type.policy_type'))
                    ->relationship('policyType', 'name')
                    ->native(false)
                    ->preload()
                    ->required()
                    ->searchable()
                    ->placeholder(__('messages.policy_sub_type.select_policy_type')),
            ])->columns(1);
    }

    public static function getModelLabel(): string
    {
        return __('messages.policy_sub_type.policy_sub_type');
    }

    public static function getPluralModelLabel(): string
    {
        return __('messages.policy_sub_type.policy_sub_types');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('messages.policy_sub_type.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('policyType.name')
                    ->label(__('messages.policy_sub_type.policy_type'))
                    ->searchable()
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50, 100])
            ->filters([
                //
            ])
            ->actionsColumnLabel(__('messages.user.actions'))
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('sm')
                    ->successNotificationTitle(__('messages.policy_sub_type.policy_sub_type_updated_successfully'))
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle(__('messages.policy_sub_type.policy_sub_type_deleted_successfully'))
                    ->iconButton(),
            ])
            ->paginated([10, 25, 50, 100])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePolicySubTypes::route('/'),
        ];
    }
}
