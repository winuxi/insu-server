<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgentResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;

class AgentResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    public static function getNavigationGroup(): ?string
    {
        return \App\Enums\NavigationGroup::BUSINESS_MANAGEMENT->label();
    }

    protected static ?int $navigationSort = 7;

    public static function getModelLabel(): string
    {
        return __('messages.agent.agents');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(agentNumberPrefix($form->getRecord()?->id))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('messages.agent.name'))
                            ->placeholder(__('messages.agent.name'))
                            ->maxLength(255)
                            ->required(),
                        TextInput::make('email')
                            ->label(__('messages.agent.email'))
                            ->placeholder(__('messages.agent.email'))
                            ->email()
                            ->maxLength(255)
                            ->required(),
                        PhoneInput::make('phone')
                            ->label(__('messages.agent.phone_number'))
                            ->rules(['required', 'phone:AUTO'])
                            ->validationMessages([
                                'phone' => __('messages.user.invalid_phone_number'), // Reusing user's invalid phone message
                            ])
                            ->required(),
                        Select::make('gender')
                            ->label(__('messages.customer.gender'))
                            ->required()
                            ->options(User::GENDERS)
                            ->native(false),
                        TextInput::make('city')
                            ->label(__('messages.agent.city'))
                            ->placeholder(__('messages.agent.city'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('state')
                            ->label(__('messages.agent.state'))
                            ->placeholder(__('messages.agent.state'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('country')
                            ->label(__('messages.agent.country'))
                            ->placeholder(__('messages.agent.country'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('zip')
                            ->label(__('messages.agent.zip'))
                            ->placeholder(__('messages.agent.zip'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('password')
                            ->password()
                            ->label(__('messages.user.password'))
                            ->placeholder(__('messages.user.password'))
                            ->maxLength(255)
                            ->visibleOn('create')
                            ->revealable()
                            ->required(),
                        TextInput::make('password_confirmation')
                            ->password()
                            ->label(__('messages.user.confirm_password'))
                            ->placeholder(__('messages.user.confirm_password'))
                            ->maxLength(255)
                            ->visibleOn('create')
                            ->revealable()
                            ->required(),
                        SpatieMediaLibraryFileUpload::make('profile')
                            ->image()
                            ->label(__('messages.agent.profile'))
                            ->disk(config('app.media_disk'))
                            ->required()
                            ->preserveFilenames()
                            ->collection(User::PROFILE),
                        Textarea::make('address')
                            ->label(__('messages.agent.address'))
                            ->placeholder(__('messages.agent.address'))
                            ->rows(3)
                            ->required()
                            ->maxLength(255),
                    ])->columnSpan(1)->columns(2),
                Section::make(__('messages.agent.additional_details'))
                    ->schema([
                        // user company details table
                        TextInput::make('company_name')
                            ->label(__('messages.agent.company_name'))
                            ->placeholder(__('messages.agent.company_name'))
                            ->maxLength(255),
                        TextInput::make('tax_no')
                            ->label(__('messages.agent.tax_number'))
                            ->placeholder(__('messages.agent.tax_number'))
                            ->maxLength(255),
                        Textarea::make('note')
                            ->label(__('messages.agent.note'))
                            ->placeholder(__('messages.agent.note'))
                            ->rows(2)
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])->columnSpan(1)->columns(2),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->role(User::AGENT))
            ->columns([
                TextColumn::make('name')
                    ->label(__('messages.agent.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('messages.agent.email'))
                    ->searchable()
                    ->sortable(),
                PhoneColumn::make('phone')
                    ->displayFormat(PhoneInputNumberType::INTERNATIONAL)
                    ->label(__('messages.agent.phone_number'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('address.city')
                    ->default('-')
                    ->label(__('messages.agent.city'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('address.state')
                    ->default('-')
                    ->label(__('messages.agent.state'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('address.country')
                    ->default('-')
                    ->label(__('messages.agent.country'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('companyDetail.company_name')
                    ->default('-')
                    ->label(__('messages.agent.company_name'))
                    ->searchable()
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->recordUrl(null)
            ->filters([
                //
            ])
            ->actionsColumnLabel(__('messages.user.actions')) // Reusing user's actions label
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->successNotificationTitle(__('messages.agent.agent_deleted_successfully')),
            ])
            ->paginated([10, 25, 50, 100])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAgents::route('/'),
            'create' => Pages\CreateAgent::route('/create'),
            'edit' => Pages\EditAgent::route('/{record}/edit'),
        ];
    }
}
