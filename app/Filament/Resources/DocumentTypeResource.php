<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentTypeResource\Pages;
use App\Models\DocumentType;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DocumentTypeResource extends Resource
{
    protected static ?string $model = DocumentType::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    public static function getNavigationGroup(): ?string
    {
        return \App\Enums\NavigationGroup::SYSTEM_CONFIGURATION->label();
    }

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('messages.document_type.name'))
                    ->placeholder(__('messages.document_type.name'))
                    ->maxLength(255)
                    ->required(),
            ])->columns(1);
    }

    public static function getModelLabel(): string
    {
        return __('messages.document_type.document_type');
    }

    public static function getPluralModelLabel(): string
    {
        return __('messages.document_type.document_types');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('messages.document_type.name'))
                    ->searchable()
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
                    ->modalWidth('sm')
                    ->successNotificationTitle(__('messages.document_type.document_type_updated_successfully'))
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle(__('messages.document_type.document_type_deleted_successfully'))
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
            'index' => Pages\ManageDocumentTypes::route('/'),
        ];
    }
}
