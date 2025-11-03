<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Enums\NavigationGroup;
use App\Filament\SuperAdmin\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return NavigationGroup::CMS->label();
    }

    public static function getModelLabel(): string
    {
        return __('messages.testimonial.model_label');
    }

    protected static ?int $navigationSort = 105;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('messages.testimonial.name'))
                    ->placeholder(__('messages.testimonial.name'))
                    ->maxLength(255)
                    ->required(),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->placeholder(__('messages.testimonial.title'))
                    ->label(__('messages.testimonial.title')),
                SpatieMediaLibraryFileUpload::make('image')
                    ->label(__('messages.testimonial.image'))
                    ->disk(config('app.media_disk'))
                    ->image()
                    ->required()
                    ->placeholder(__('messages.testimonial.image'))
                    ->collection(Testimonial::TESTIMONIAL_IMAGE),
                Textarea::make('description')
                    ->required()
                    ->placeholder(__('messages.testimonial.description'))
                    ->label(__('messages.testimonial.description')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('image')
                    ->label(__('messages.testimonial.image'))
                    ->collection(Testimonial::TESTIMONIAL_IMAGE),
                TextColumn::make('name')
                    ->label(__('messages.testimonial.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->label(__('messages.testimonial.title'))
                    ->searchable()
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actionsColumnLabel(__('messages.testimonial.actions'))
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->successNotificationTitle(__('messages.testimonial.updated_successfully')),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->successNotificationTitle(__('messages.testimonial.deleted_successfully')),
            ])
            ->paginated([10, 25, 50, 100])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTestimonials::route('/'),
        ];
    }
}
