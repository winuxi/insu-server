<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClaimResource\Pages;
use App\Models\Claim;
use App\Models\Insurance;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ClaimResource extends Resource
{
    protected static ?string $model = Claim::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function getNavigationGroup(): ?string
    {
        return \App\Enums\NavigationGroup::BUSINESS_MANAGEMENT->label();
    }

    public static function getModelLabel(): string
    {
        return __('messages.claim.claim');
    }

    protected static ?int $navigationSort = 11;

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
            // If agent has manage_claim permission, they can access
            if ($user->hasTenantPermission('manage_claim')) {
                return true;
            }

            // If agent has any of the specific claim permissions, they can access
            if ($user->hasTenantPermissionAny(['show_claim', 'edit_claim', 'delete_claim', 'create_claim'])) {
                return true;
            }
        }

        return false;
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
            return $user->hasTenantPermissionAny(['manage_claim', 'create_claim']);
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
            return $user->hasTenantPermissionAny(['manage_claim', 'edit_claim']);
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
            return $user->hasTenantPermissionAny(['manage_claim', 'show_claim']);
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
            return $user->hasTenantPermissionAny(['manage_claim', 'delete_claim']);
        }

        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('claim_number')
                    ->label(__('messages.claim.claim_number'))
                    ->placeholder(__('messages.claim.enter_claim_number'))
                    ->maxLength(255)
                    ->prefix(claimNumberPrefix(isClean: true))
                    ->afterStateHydrated(function ($operation, $state, $set) {
                        if ($operation === 'edit') {
                            $set('claim_number', Str::after($state, claimNumberPrefix(isClean: true)));
                        }
                    })
                    ->dehydrateStateUsing(fn ($state) => claimNumberPrefix(isClean: true).$state)
                    ->inlinePrefix(true)
                    ->required(),
                DatePicker::make('claim_date')
                    ->label(__('messages.claim.claim_date'))
                    ->native(false)
                    ->required(),
                Select::make('customer_id')
                    ->label(__('messages.claim.customer'))
                    ->placeholder(__('messages.claim.select_customer'))
                    ->relationship('customer', 'name', fn ($query) => Auth::user()->hasRole(User::CUSTOMER) ? $query->role('customer')->where('id', Auth::user()->id) : $query->role('customer'))
                    ->default(Auth::user()->hasRole(User::CUSTOMER) ? Auth::user()->id : null)
                    ->searchable()
                    ->native(false)
                    ->preload()
                    ->live()
                    ->afterStateUpdated(fn ($set) => $set('insurance_id', null))
                    ->required(),
                Select::make('insurance_id')
                    ->label(__('messages.claim.insurance'))
                    ->placeholder(__('messages.claim.select_insurance'))
                    ->options(function ($get) {
                        $data = Insurance::where('customer_id', $get('customer_id'))
                            ->get()
                            ->mapWithKeys(function ($insurance) {
                                return [
                                    $insurance->id => insuranceCustomerPrefix($insurance->id),
                                ];
                            })->toArray();

                        return $data;
                    })
                    ->disabled(fn ($get) => empty($get('customer_id')))
                    ->live()
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required(),
                Select::make('status')
                    ->label(__('messages.claim.status'))
                    ->options(Auth::user()->hasRole(User::CUSTOMER) ? Arr::only(Claim::STATUS, Claim::UNDER_REVIEW) : Claim::STATUS)
                    ->default(Auth::user()->hasRole(User::CUSTOMER) ? Claim::UNDER_REVIEW : null)
                    ->native(false)
                    ->required(),
                Textarea::make('reason')
                    ->label(__('messages.claim.reason'))
                    ->placeholder(__('messages.claim.enter_reason_for_claim'))
                    ->required(),
                Textarea::make('note')
                    ->label(__('messages.claim.note'))
                    ->placeholder(__('messages.claim.enter_additional_note'))
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $statusColumn = null;
        if (Auth::user()->hasRole(User::ADMIN)) {
            $statusColumn = SelectColumn::make('status')
                ->options(Claim::STATUS)
                ->selectablePlaceholder(false)
                ->label(__('messages.claim.status'))
                ->afterStateUpdated(function ($record, $state) {
                    $record->update(['status' => $state]);
                    $record->save();

                    return notify(__('messages.claim.claim_status_updated_successfully'), 'success');
                });
        } else {
            $statusColumn = TextColumn::make('status')
                ->label(__('messages.claim.status'))
                ->badge()
                ->formatStateUsing(fn ($state) => Claim::STATUS[$state])
                ->color(fn ($state) => Claim::statusColor($state))
                ->sortable();
        }

        return $table
            ->modifyQueryUsing(function ($query) {
                if (Auth::user()->role->name == User::AGENT) {
                    return $query->whereHas('insurance', function ($q) {
                        $q->where('agent_id', Auth::id());
                    });
                } elseif (Auth::user()->role->name == User::CUSTOMER) {
                    return $query->where('customer_id', Auth::id());
                }

                return $query;
            })
            ->columns([
                TextColumn::make('claim_number')
                    ->label(__('messages.claim.claim_number'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('claim_date')
                    ->label(__('messages.claim.claim_date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('insurance.policy.title')
                    ->label(__('messages.claim.insurance'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer.name')
                    ->label(__('messages.claim.customer'))
                    ->searchable()
                    ->hidden(fn () => Auth::user()->hasRole(User::CUSTOMER))
                    ->sortable(),
                $statusColumn,
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('messages.claim.status'))
                    ->options(Claim::STATUS)
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()
                    ->modalHeading(fn ($record) => $record?->claim_number), // claim_number is dynamic, not directly localizable here
                Tables\Actions\EditAction::make()->iconButton()
                    ->before(function ($data, $record, $action) {
                        if (Claim::where('claim_number', $data['claim_number'])->whereNot('id', $record->id)->exists()) {
                            notify(__('messages.claim.claim_number_already_exist'), 'danger');
                            $action->halt();
                        }
                    })
                    ->successNotificationTitle(__('messages.claim.claim_updated_successfully')),
                Tables\Actions\DeleteAction::make()->iconButton()
                    ->successNotificationTitle(__('messages.claim.claim_deleted_successfully')),
            ])
            ->paginated([10, 25, 50, 100])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageClaims::route('/'),
            'view' => Pages\ViewClaim::route('/{record}'),
        ];
    }
}
