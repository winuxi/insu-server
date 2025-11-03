<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DurationResource\Pages;
use App\Models\Duration;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DurationResource extends Resource
{
    protected static ?string $model = Duration::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function getNavigationGroup(): ?string
    {
        return \App\Enums\NavigationGroup::BUSINESS_MANAGEMENT->label();
    }

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('duration_terms')
                    ->label(__('messages.duration.duration_terms'))
                    ->placeholder(__('messages.duration.duration_terms'))
                    ->maxLength(255)
                    ->required(),
                TextInput::make('duration_in_months')
                    ->label(__('messages.duration.duration_in_months'))
                    ->numeric()
                    ->extraInputAttributes(['oninput' => "this.value = this.value.replace(/[e\-]/gi, '')"])
                    ->placeholder(__('messages.duration.duration_in_months'))
                    ->required(),
            ])->columns(1);
    }

    public static function getModelLabel(): string
    {
        return __('messages.duration.duration');
    }

    public static function getPluralModelLabel(): string
    {
        return __('messages.duration.durations');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('duration_terms')
                    ->label(__('messages.duration.duration_terms'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('duration_in_months')
                    ->label(__('messages.duration.duration_in_months'))
                    ->searchable()
                    ->badge()
                    ->alignCenter()
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50, 100])
            ->filters([
                //
            ])
            ->actionsColumnLabel(__('messages.user.actions')) // Reusing actions label
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->modalWidth('sm')
                    ->successNotificationTitle(__('messages.duration.duration_updated_successfully')),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->action(function ($record) {
                        try {
                            $record->delete();
                            notify('Duration deleted successfully', 'success');
                        } catch (\Exception $e) {
                            notify('This duration is in use and cannot be deleted', 'danger');
                        }
                    })
                    ->successNotificationTitle(__('messages.duration.duration_deleted_successfully')),
            ])
            ->paginated([10, 25, 50, 100])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDurations::route('/'),
        ];
    }
}
