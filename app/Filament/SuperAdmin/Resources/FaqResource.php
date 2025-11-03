<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Enums\NavigationGroup;
use App\Filament\SuperAdmin\Resources\FaqResource\Pages\ManageFaqs;
use App\Models\Faq;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?int $navigationSort = 106;

    public static function getNavigationGroup(): ?string
    {
        return NavigationGroup::CMS->label();
    }

    public static function getModelLabel(): string
    {
        return __('messages.faq.model_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('question')
                    ->required()
                    ->label(__('messages.faq.question'))
                    ->placeholder(__('messages.faq.question'))
                    ->maxLength(255),
                Textarea::make('answer')
                    ->required()
                    ->label(__('messages.faq.answer'))
                    ->rows(3)
                    ->placeholder(__('messages.faq.answer')),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')
                    ->label(__('messages.faq.question'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('answer')
                    ->label(__('messages.faq.answer'))
                    ->searchable()
                    ->words(5)
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actionsColumnLabel(__('messages.faq.actions'))
            ->actions([
                Tables\Actions\EditAction::make()->iconButton()->successNotificationTitle(__('messages.faq.updated_successfully')),
                Tables\Actions\DeleteAction::make()->iconButton()->successNotificationTitle(__('messages.faq.deleted_successfully')),
            ])
            ->paginated([10, 25, 50, 100])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageFaqs::route('/'),
        ];
    }
}
