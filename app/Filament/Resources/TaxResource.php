<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxResource\Pages;
use App\Models\Tax;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TaxResource extends Resource
{
    protected static ?string $model = Tax::class;

    protected static ?string $navigationIcon = 'heroicon-o-percent-badge';

    public static function getNavigationGroup(): ?string
    {
        return \App\Enums\NavigationGroup::BUSINESS_MANAGEMENT->label();
    }

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('tax')
                    ->label(__('messages.tax.tax'))
                    ->placeholder(__('messages.tax.tax'))
                    ->maxLength(255)
                    ->required(),
                TextInput::make('tax_rate')
                    ->label(__('messages.tax.tax_rate'))
                    ->placeholder(__('messages.tax.tax_rate'))
                    ->numeric()
                    ->extraInputAttributes(['oninput' => "this.value = this.value.replace(/[e\-]/gi, '')"])
                    ->required(),
            ])->columns(1);
    }

    public static function getModelLabel(): string
    {
        return __('messages.tax.tax');
    }

    public static function getPluralModelLabel(): string
    {
        return __('messages.tax.taxes');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tax')
                    ->label(__('messages.tax.tax'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tax_rate')
                    ->label(__('messages.tax.tax_rate'))
                    ->searchable()
                    ->badge()
                    ->suffix('%')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actionsColumnLabel(__('messages.user.actions'))
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('sm')
                    ->successNotificationTitle(__('messages.tax.tax_updated_successfully'))
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle(__('messages.tax.tax_deleted_successfully'))
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
            'index' => Pages\ManageTaxes::route('/'),
        ];
    }
}
