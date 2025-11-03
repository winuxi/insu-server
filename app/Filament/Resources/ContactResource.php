<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-oval-left-ellipsis';

    public static function getNavigationGroup(): ?string
    {
        return \App\Enums\NavigationGroup::BUSINESS_MANAGEMENT->label();
    }

    public static function getModelLabel(): string
    {
        return __('messages.contact.contact');
    }

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('messages.contact.contact_information'))
                    ->columns(1)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('messages.contact.name'))
                            ->placeholder(__('messages.contact.enter_your_name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label(__('messages.contact.email'))
                            ->placeholder(__('messages.contact.enter_your_email'))
                            ->email()
                            ->required()
                            ->maxLength(255),
                        PhoneInput::make('phone')
                            ->label(__('messages.contact.phone'))
                            ->rules(['required', 'phone:AUTO'])
                            ->validationMessages([
                                'phone' => __('messages.user.invalid_phone_number'), // Reusing user's message
                            ])
                            ->required(),
                        TextInput::make('subject')
                            ->label(__('messages.contact.subject'))
                            ->placeholder(__('messages.contact.enter_subject'))
                            ->required()
                            ->maxLength(255),
                        Textarea::make('message')
                            ->label(__('messages.contact.message'))
                            ->placeholder(__('messages.contact.enter_your_message'))
                            ->required()
                            ->maxLength(1000)
                            ->columnSpanFull()
                            ->rows(3),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('messages.contact.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('messages.contact.email'))
                    ->searchable()
                    ->sortable(),
                PhoneColumn::make('phone')
                    ->displayFormat(PhoneInputNumberType::INTERNATIONAL)
                    ->label(__('messages.contact.phone'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label(__('messages.contact.subject'))
                    ->searchable()
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50, 100])
            ->recordUrl(null)
            ->filters([
                //
            ])
            ->actionsColumnLabel(__('messages.user.actions'))
            ->actions([
                Tables\Actions\EditAction::make()->iconButton()
                    ->successNotificationTitle(__('messages.contact.contact_updated_successfully')),
                Tables\Actions\DeleteAction::make()->iconButton()
                    ->successNotificationTitle(__('messages.contact.contact_deleted_successfully')),
            ])
            ->paginated([10, 25, 50, 100])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
