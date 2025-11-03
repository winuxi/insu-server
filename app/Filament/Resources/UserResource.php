<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function getModelLabel(): string
    {
        return __('messages.user.user');
    }

    public static function getNavigationGroup(): ?string
    {
        return \App\Enums\NavigationGroup::BUSINESS_MANAGEMENT->label();
    }

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('messages.user.user_information'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('messages.user.name'))
                            ->maxLength(255)
                            ->placeholder(__('messages.user.name'))
                            ->required(),
                        TextInput::make('email')
                            ->email()
                            ->unique('users', 'email', ignoreRecord: true)
                            ->label(__('messages.user.email'))
                            ->placeholder(__('messages.user.email'))
                            ->maxLength(255)
                            ->required(),
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
                        PhoneInput::make('phone')
                            ->label(__('messages.user.phone'))
                            ->required()
                            ->rules(['required', 'phone:AUTO'])
                            ->validationMessages([
                                'phone' => __('messages.user.invalid_phone_number'),
                            ]),
                        Select::make('gender')
                            ->label(__('messages.user.gender'))
                            ->required()
                            ->options(User::GENDERS)
                            ->native(false),
                        Select::make('role')
                            ->label(__('messages.user.role'))
                            ->required()
                            ->placeholder(__('messages.user.role'))
                            ->hidden(Auth::user()->hasRole(User::SUPER_ADMIN))
                            ->relationship('roles', 'name', function ($set, $query, $operation) {
                                $count = $query->count();

                                $set('role_count', $count);
                                if (Auth::user()->hasRole(User::SUPER_ADMIN)) {
                                    return $query;
                                } else {
                                    return $query->where('name', '!=', User::SUPER_ADMIN)->where('name', '!=', User::ADMIN)->where('tenant_id', Auth::user()->tenant_id);
                                }
                            })
                            ->disabled(function ($record, $operation) {
                                if ($operation == 'edit' && $record?->hasRole(User::CUSTOMER)) {
                                    return true;
                                }

                                return false;
                            })
                            ->disableOptionWhen(function (string $value, $record, $operation) {
                                if (Auth::user()->hasRole(User::SUPER_ADMIN)) {
                                    return $value != Role::where('name', User::ADMIN)->first()->id;
                                }
                            })
                            ->default(function () {
                                if (Auth::user()->hasRole(User::SUPER_ADMIN)) {
                                    return Role::where('name', User::ADMIN)->first()->id;
                                }
                            })
                            ->live()
                            ->optionsLimit(fn ($get) => $get('role_count'))
                            ->preload()
                            ->searchable()
                            ->native(false),
                        SpatieMediaLibraryFileUpload::make('profile')
                            ->image()
                            ->label(__('messages.user.profile'))
                            ->required()
                            ->preserveFilenames()
                            ->disk(config('app.media_disk'))
                            ->collection(User::PROFILE),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                if (Auth::user()->hasRole(User::SUPER_ADMIN)) {
                    return $query->withOutGlobalScopes()->whereHas('roles', fn ($q) => $q->where('name', User::ADMIN));
                }

                return $query->whereNot('id', Auth::user()->id)->whereHas('roles', fn ($q) => $q->where('name', '!=', User::SUPER_ADMIN));
            })
            ->columns([
                SpatieMediaLibraryImageColumn::make('profile')
                    ->label(__('messages.user.profile'))
                    ->circular()
                    ->defaultImageUrl(asset('images/avatar.png'))
                    ->collection(User::PROFILE),
                TextColumn::make('name')
                    ->label(__('messages.user.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('messages.user.email'))
                    ->searchable()
                    ->sortable(),
                PhoneColumn::make('phone')
                    ->displayFormat(PhoneInputNumberType::INTERNATIONAL)
                    ->label(__('messages.user.phone'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('gender')
                    ->label(__('messages.user.gender'))
                    ->formatStateUsing(fn ($record) => User::GENDERS[$record->gender] ?? null)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role.name')
                    ->badge(fn ($state) => ($state === User::ADMIN || $state === User::CUSTOMER || $state === User::AGENT))
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->color(function ($state) {
                        if ($state === User::ADMIN) {
                            return 'danger';
                        } elseif ($state === User::CUSTOMER) {
                            return 'warning';
                        } elseif ($state === User::AGENT) {
                            return 'success';
                        }
                    })
                    ->hidden(Auth::user()->hasRole(User::SUPER_ADMIN))
                    ->label(__('messages.user.role')),
                ToggleColumn::make('email_verified_at')
                    ->label(__('messages.mails.email_verification'))
                    ->disabled(fn ($record) => ! is_null($record->email_verified_at))
                    ->updateStateUsing(function ($record, $state) {
                        if (! $record->email_verified_at) {
                            $record->email_verified_at = $state ? now() : null;
                            $record->save();
                            notify(__('messages.common.email_varification'));
                        }
                    })
                    ->alignCenter(),
                TextColumn::make('created_at')
                    ->label(__('messages.user.created_at'))
                    ->date()
                    ->sortable(),
            ])
            ->recordUrl(null)
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('role')
                    ->label(__('messages.user.role'))
                    ->hidden(Auth::user()->hasRole(User::SUPER_ADMIN))
                    ->relationship('roles', 'name', function ($query) {
                        if (Auth::user()->hasRole(User::ADMIN)) {
                            return $query->where('name', '!=', User::SUPER_ADMIN)->where('name', '!=', User::ADMIN)->where('tenant_id', Auth::user()->tenant_id);
                        }
                    })
                    ->multiple()
                    ->preload()
                    ->searchable(),
            ])
            ->actionsColumnLabel(__('messages.user.actions'))
            ->actions([
                Tables\Actions\EditAction::make()->iconButton()->hidden(fn (User $record): bool => $record->id == Auth::user()->id),
                Tables\Actions\DeleteAction::make()
                    ->action(function (User $record) {
                        if ($record->id == Auth::user()->id) {
                            return notify(__('messages.user.cannot_delete_yourself'), 'warning');
                        }

                        $record->delete();

                        return notify(__('messages.user.user_deleted_successfully'));
                    })
                    ->iconButton(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
