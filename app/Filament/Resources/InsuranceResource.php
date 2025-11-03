<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InsuranceResource\Pages;
use App\Models\Insurance;
use App\Models\Policy;
use App\Models\PolicyPricing;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables; // Added Auth facade
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class InsuranceResource extends Resource
{
    protected static ?string $model = Insurance::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    public static function getNavigationGroup(): ?string
    {
        return \App\Enums\NavigationGroup::BUSINESS_MANAGEMENT->label();
    }

    protected static ?int $navigationSort = 9;

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
            // If agent has manage_insurance permission, they can access
            if ($user->hasTenantPermission('manage_insurance')) {
                return true;
            }

            // If agent has any of the specific insurance permissions, they can access
            if ($user->hasTenantPermissionAny(['show_insurance', 'edit_insurance', 'delete_insurance', 'create_insurance'])) {
                return true;
            }

            // If agent doesn't have manage_insurance and no other permissions, deny access
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
            return $user->hasTenantPermissionAny(['manage_insurance', 'create_insurance']);
        }

        return false;
    }

    public static function canEdit($record): bool
    {
        $user = Auth::user();
        if ($user->hasRole(User::CUSTOMER)) {
            return false;
        }
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
            return $user->hasTenantPermissionAny(['manage_insurance', 'edit_insurance']);
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
            return $user->hasTenantPermissionAny(['manage_insurance', 'show_insurance']);
        }

        return false;
    }

    public static function canDelete($record): bool
    {
        $user = Auth::user();
        if ($user->hasRole(User::CUSTOMER)) {
            return false;
        }
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
            return $user->hasTenantPermissionAny(['manage_insurance', 'delete_insurance']);
        }

        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(insuranceCustomerPrefix($form->getRecord()?->id)) // Dynamic, not localizing prefix directly
                    ->schema([
                        Select::make('customer_id')
                            ->label(__('messages.insurance.customer'))
                            ->relationship('customer', 'name', fn ($query) => Auth::user()->hasRole(User::CUSTOMER) ? $query->role('customer')->where('id', Auth::user()->id) : $query->role('customer'))
                            ->default(Auth::user()->hasRole(User::CUSTOMER) ? Auth::user()->id : null)
                            ->searchable()
                            ->preload()
                            ->required(),
                        Group::make()
                            ->schema(function ($get) {
                                $customer = User::find($get('customer_id'));

                                return [
                                    Placeholder::make('email')
                                        ->label(__('messages.insurance.email'))
                                        ->content($customer?->email),
                                    Placeholder::make('phone')
                                        ->label(__('messages.insurance.phone_number'))
                                        ->content($customer?->phone),
                                    Placeholder::make('address')
                                        ->label(__('messages.insurance.address'))
                                        ->content($customer?->addresses()?->first()?->address)
                                        ->columnSpanFull(),
                                ];
                            })->visible(fn ($get) => $get('customer_id'))->columnSpanFull()->columns(2),
                    ])->columnSpan(1),
                Section::make(__('messages.insurance.policy_details'))
                    ->schema([
                        Select::make('policy_id')
                            ->label(__('messages.insurance.policy'))
                            ->relationship('policy', 'title')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Group::make()
                            ->schema(function ($get) {
                                if (! $get('policy_id')) {
                                    return [];
                                }
                                $policy = Policy::find($get('policy_id'));
                                $currencySymbol = currencySymbol();
                                $durations = $policy?->policyPricings
                                    ->filter(fn ($pricing) => $pricing->duration)
                                    ->mapWithKeys(function ($pricing) use ($currencySymbol) {
                                        return [
                                            $pricing->id => "{$pricing->duration->duration_terms} - {$currencySymbol} {$pricing->price}",
                                        ];
                                    })
                                    ->toArray();

                                return [
                                    Placeholder::make('policy_type')
                                        ->label(__('messages.insurance.policy_type'))
                                        ->content($policy?->policyType?->name),
                                    Placeholder::make('policy_sub_type')
                                        ->label(__('messages.insurance.policy_sub_type'))
                                        ->content($policy?->policySubType?->name),
                                    Placeholder::make('sum_assured')
                                        ->label(__('messages.insurance.sum_assured'))
                                        ->content($policy?->sum_assured),
                                    Placeholder::make('liability_risk')
                                        ->label(__('messages.insurance.liability_risk'))
                                        ->content(Policy::LIABILITY_RISKS[$policy?->liability_risk] ?? 'N/A'), // 'N/A' could be localized
                                    Placeholder::make('coverage_type')
                                        ->label(__('messages.insurance.coverage_type'))
                                        ->content(Policy::COVERAGE_TYPES[$policy?->coverage_type] ?? 'N/A'), // 'N/A' could be localized
                                    Placeholder::make('total_insured_person')
                                        ->label(__('messages.insurance.total_insured_person'))
                                        ->content($policy?->total_insured_person),
                                    Fieldset::make()
                                        ->schema([
                                            ToggleButtons::make('policy_pricing_id')
                                                ->label(__('messages.insurance.policy_pricing'))
                                                ->columnSpanFull()
                                                ->inline()
                                                ->options($durations)
                                                ->required(fn ($get) => $get('policy_id')),
                                        ]),
                                ];
                            })->visible(fn ($get) => $get('policy_id'))->columnSpanFull()->columns(3),
                    ])->columnSpan(1),
                Section::make(__('messages.insurance.agent_details'))
                    ->hidden(Auth::user()->role->name == User::AGENT)
                    ->schema([
                        Select::make('agent_id')
                            ->label(__('messages.insurance.agent'))
                            ->relationship('agent', 'name', fn ($query) => $query->role('agent'))
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('agent_commission')
                            ->label(__('messages.insurance.agent_commission'))
                            ->numeric()
                            ->extraInputAttributes(['oninput' => "this.value = this.value.replace(/[e\-]/gi, '')"])
                            ->suffix('%')
                            ->placeholder(__('messages.insurance.agent_commission'))
                            ->required(),
                    ])->columnSpan(1)->columns(2),
                Section::make(__('messages.insurance.other_information'))
                    ->schema([
                        DatePicker::make('start_date')
                            ->label(__('messages.insurance.start_date'))
                            ->required()
                            ->native(false)
                            ->columnSpanFull(Auth::user()->role->name == User::AGENT)
                            ->default(today()),
                        Hidden::make('status')->default(Insurance::IN_REVIEW)->visible(Auth::user()->role->name == User::AGENT),
                        Select::make('status')
                            ->label(__('messages.insurance.status'))
                            ->options(Insurance::STATUSES) // Consider localizing STATUSES array values if they are user-facing
                            ->hidden(Auth::user()->role->name == User::AGENT)
                            ->native(false)
                            ->required(),
                        Textarea::make('note')
                            ->label(__('messages.insurance.note'))
                            ->placeholder(__('messages.insurance.note'))
                            ->columnSpanFull(),
                    ])->columnSpan(1)->columns(2),
                Section::make(__('messages.insurance.installment_preview'))
                    ->visible(fn ($get) => $get('policy_pricing_id'))
                    ->schema(function ($get) {
                        $preview = [];

                        if ($get('policy_pricing_id')) {
                            $policyPricing = PolicyPricing::find($get('policy_pricing_id'));
                            $installmentCount = $policyPricing->duration->duration_in_months;
                            $amount = number_format($policyPricing->price / $installmentCount, 2);

                            for ($i = 1; $i <= $installmentCount; $i++) {
                                $preview[] = Placeholder::make('order_no'.$i)
                                    ->label(__('messages.insurance.order_no'))
                                    ->content($i)
                                    ->hiddenLabel($i !== 1);

                                $preview[] = Placeholder::make('amount'.$i)
                                    ->label(__('messages.insurance.amount'))
                                    ->content($amount)
                                    ->hiddenLabel($i !== 1); // hide label if not first
                            }
                        }

                        return $preview;
                    })->columnSpan(Auth::user()->role->name == User::AGENT ? 1 : 2)->columns(2),
            ])->live();
    }

    public static function getModelLabel(): string
    {
        return __('messages.insurance.insurance');
    }

    public static function getPluralModelLabel(): string
    {
        return __('messages.insurance.insurances');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                if (Auth::user()->role->name == User::AGENT) {
                    return $query->where('agent_id', Auth::id());
                } elseif (Auth::user()->role->name == User::CUSTOMER) {
                    return $query->where('customer_id', Auth::id());
                }

                return $query;
            })
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('messages.insurance.insurance'))
                    ->formatStateUsing(fn ($state) => insuranceCustomerPrefix($state))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('policy.title')
                    ->label(__('messages.insurance.policy'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('policy.policySubType.name')
                    ->label(__('messages.insurance.policy_sub_type'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('policy.policyType.name')
                    ->label(__('messages.insurance.policy_type'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label(__('messages.insurance.policy_holder'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('agent.name')
                    ->label(__('messages.insurance.agent'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label(__('messages.insurance.start_date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expiry_date')
                    ->label(__('messages.insurance.expiry_date'))
                    ->state(fn ($record) => \Carbon\Carbon::parse($record->start_date)->addMonths((int) $record->policyPricing?->duration?->duration_in_months ?? 0))
                    ->date()
                    ->sortable(['start_date']),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('messages.insurance.status'))
                    ->formatStateUsing(fn ($state) => Insurance::STATUSES[$state]) // Consider localizing STATUSES array values
                    ->badge()
                    ->color(fn ($state) => Insurance::statusColor($state))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50, 100])
            ->recordUrl(null)
            ->actionsColumnLabel(__('messages.user.actions'))
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle(__('messages.insurance.insurance_deleted_successfully'))
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
            'index' => Pages\ListInsurance::route('/'),
            'create' => Pages\CreateInsurance::route('/create'),
            'view' => Pages\ViewInsurance::route('/{record}'),
            'edit' => Pages\EditInsurance::route('/{record}/edit'),
        ];
    }
}
