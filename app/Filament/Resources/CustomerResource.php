<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
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
use Illuminate\Support\Facades\Auth; // Added Auth facade
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;

class CustomerResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getNavigationGroup(): ?string
    {
        return \App\Enums\NavigationGroup::BUSINESS_MANAGEMENT->label();
    }

    protected static ?int $navigationSort = 6;

    public static function getModelLabel(): string
    {
        return __('messages.customer.customers');
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();

        // Super admin can always access
        if ($user->hasRole(User::SUPER_ADMIN)) {
            return true;
        }

        // Admin within their tenant can access
        if ($user->hasRole(User::ADMIN)) {
            return true;
        }

        // Agent within their tenant with proper permissions
        if ($user->hasTenantRole(User::AGENT)) {
            // If agent has manage_customer permission, they can access
            if ($user->hasTenantPermission('manage_customer')) {
                return true;
            }

            // If agent has any of the specific customer permissions, they can access
            if ($user->hasTenantPermissionAny(['show_customer', 'edit_customer', 'delete_customer', 'create_customer'])) {
                return true;
            }

            // If agent doesn't have manage_customer and no other permissions, deny access
            return false;
        }

        return true; // Default allow for other roles
    }

    public static function canCreate(): bool
    {
        $user = Auth::user();

        // Super admin can always create
        if ($user->hasRole(User::SUPER_ADMIN)) {
            return true;
        }

        // Admin within their tenant can create
        if ($user->hasRole(User::ADMIN)) {
            return true;
        }

        // Agent within their tenant with proper permissions
        if ($user->hasTenantRole(User::AGENT)) {
            return $user->hasTenantPermissionAny(['manage_customer', 'create_customer']);
        }

        return false;
    }

    public static function canEdit($record): bool
    {
        $user = Auth::user();

        // Super admin can always edit
        if ($user->hasRole(User::SUPER_ADMIN)) {
            return true;
        }

        // Admin within their tenant can edit
        if ($user->hasRole(User::ADMIN)) {
            return true;
        }

        // Agent within their tenant with proper permissions
        if ($user->hasTenantRole(User::AGENT)) {
            return $user->hasTenantPermissionAny(['manage_customer', 'edit_customer']);
        }

        return false;
    }

    public static function canView($record): bool
    {
        $user = Auth::user();

        // Super admin can always view
        if ($user->hasRole(User::SUPER_ADMIN)) {
            return true;
        }

        // Admin within their tenant can view
        if ($user->hasRole(User::ADMIN)) {
            return true;
        }

        // Agent within their tenant with proper permissions
        if ($user->hasTenantRole(User::AGENT)) {
            return $user->hasTenantPermissionAny(['manage_customer', 'show_customer']);
        }

        return false;
    }

    public static function canDelete($record): bool
    {
        $user = Auth::user();

        // Super admin can always delete
        if ($user->hasRole(User::SUPER_ADMIN)) {
            return true;
        }

        // Admin within their tenant can delete
        if ($user->hasRole(User::ADMIN)) {
            return true;
        }

        // Agent within their tenant with proper permissions
        if ($user->hasTenantRole(User::AGENT)) {
            return $user->hasTenantPermissionAny(['manage_customer', 'delete_customer']);
        }

        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(invoiceCustomerPrefix($form->getRecord()?->id))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('messages.customer.name'))
                            ->placeholder(__('messages.customer.name'))
                            ->maxLength(255)
                            ->required(),
                        TextInput::make('email')
                            ->label(__('messages.customer.email'))
                            ->placeholder(__('messages.customer.email'))
                            ->email()
                            ->maxLength(255)
                            ->required(),
                        PhoneInput::make('phone')
                            ->label(__('messages.customer.phone_number'))
                            ->rules(['required', 'phone:AUTO'])
                            ->validationMessages([
                                'phone' => __('messages.user.invalid_phone_number'), // Reusing
                            ])
                            ->required(),
                        Select::make('gender')
                            ->label(__('messages.customer.gender'))
                            ->required()
                            ->options(User::GENDERS)
                            ->native(false),
                        // user address table
                        TextInput::make('city')
                            ->label(__('messages.customer.city'))
                            ->placeholder(__('messages.customer.city'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('state')
                            ->label(__('messages.customer.state'))
                            ->placeholder(__('messages.customer.state'))
                            ->required()
                            ->autocomplete()
                            ->maxLength(255),
                        TextInput::make('country')
                            ->label(__('messages.customer.country'))
                            ->placeholder(__('messages.customer.country'))
                            ->required(),
                        TextInput::make('zip')
                            ->label(__('messages.customer.zip'))
                            ->placeholder(__('messages.customer.zip'))
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
                            ->label(__('messages.customer.profile'))
                            ->required()
                            ->disk(config('app.media_disk'))
                            ->preserveFilenames()
                            ->collection(User::PROFILE),
                        Textarea::make('address')
                            ->label(__('messages.customer.address'))
                            ->placeholder(__('messages.customer.address'))
                            ->rows(2)
                            ->required()
                            ->maxLength(255),
                    ])->columnSpan(1)->columns(2),
                Section::make(__('messages.customer.additional_details'))
                    ->schema([
                        // user company details table
                        TextInput::make('company_name')
                            ->label(__('messages.customer.company_name'))
                            ->placeholder(__('messages.customer.company_name'))
                            ->maxLength(255),
                        TextInput::make('tax_no')
                            ->label(__('messages.customer.tax_number'))
                            ->placeholder(__('messages.customer.tax_number'))
                            ->maxLength(255),
                        DatePicker::make('dob')
                            ->label(__('messages.customer.dob'))
                            ->maxDate(today()->subDay())
                            ->placeholder(__('messages.customer.dob'))
                            ->native(false),
                        TextInput::make('age')
                            ->label(__('messages.customer.age'))
                            ->placeholder(__('messages.customer.age'))
                            ->numeric()
                            ->extraInputAttributes(['oninput' => "this.value = this.value.replace(/[e\-]/gi, '')"])
                            ->maxLength(255),
                        Select::make('marital_status')
                            ->label(__('messages.customer.marital_status'))
                            ->options(User::MARITAL_STATUS)
                            ->native(false),
                        TextInput::make('blood_group')
                            ->label(__('messages.customer.blood_group'))
                            ->placeholder(__('messages.customer.blood_group'))
                            ->extraAlpineAttributes(['oninput' => "this.value = this.value.replace(/[^A-Za-z+-]/g, '')"])
                            ->maxLength(255),
                        TextInput::make('height')
                            ->label(__('messages.customer.height'))
                            ->placeholder(__('messages.customer.height'))
                            ->maxLength(255),
                        TextInput::make('weight')
                            ->label(__('messages.customer.weight'))
                            ->placeholder(__('messages.customer.weight'))
                            ->maxLength(255),
                        Textarea::make('note')
                            ->label(__('messages.customer.note'))
                            ->placeholder(__('messages.customer.note'))
                            ->rows(2)
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])->columnSpan(1)->columns(2),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                $base = $query->role(User::CUSTOMER);
                $roleName = Auth::user()->role->name;

                if ($roleName == User::ADMIN) {
                    return $base;
                } else {
                    return $base
                        ->where('created_by_id', Auth::id())
                        ->orWhereHas('customerInsurances', fn ($q) => $q->where('agent_id', Auth::id()));
                }
            })

            ->columns([
                TextColumn::make('name')
                    ->label(__('messages.customer.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('messages.customer.email'))
                    ->searchable()
                    ->sortable(),
                PhoneColumn::make('phone')
                    ->displayFormat(PhoneInputNumberType::INTERNATIONAL)
                    ->label(__('messages.customer.phone_number'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('address.city')
                    ->default('-')
                    ->label(__('messages.customer.city'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('address.state')
                    ->default('-')
                    ->label(__('messages.customer.state'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('address.country')
                    ->default('-')
                    ->label(__('messages.customer.country'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('companyDetail.company_name')
                    ->default('-')
                    ->label(__('messages.customer.company_name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('policy_count')
                    ->label(__('messages.customer.policy_assigned'))
                    ->state(fn ($record) => $record->customerInsurances()->with('policy')->get()->pluck('policy')->count())
                    ->alignCenter()
                    ->badge(),
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50, 100])
            ->recordUrl(null)
            ->filters([
                //
            ])
            ->actionsColumnLabel(function () { // Conditional label
                if (Auth::user()->role->name !== User::AGENT) {
                    return __('messages.user.actions'); // Reusing
                }

                return null;
            })
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->successNotificationTitle(__('messages.customer.customer_deleted_successfully')),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
