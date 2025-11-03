<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Installment;
use App\Models\Insurance;
use App\Models\InsurancePayment;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PaymentResource extends Resource
{
    protected static ?string $model = InsurancePayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function getNavigationGroup(): ?string
    {
        return \App\Enums\NavigationGroup::BUSINESS_MANAGEMENT->label();
    }

    protected static ?int $navigationSort = 13;

    public static function getModelLabel(): string
    {
        return __('messages.payment.payments');
    }

    // public static function canAccess(): bool
    // {
    //     return ! Auth::user()->hasRole(User::ADMIN);
    // }

    public static function form(Form $form): Form
    {
        $usedInstallmentIds = InsurancePayment::pluck('installment_id')
            ->where('status', '!=', InsurancePayment::PAID)
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        return $form
            ->schema([
                Group::make([
                    Select::make('insurance_id')
                        ->label(__('messages.insurance.insurance'))
                        ->options(
                            Insurance::whereHas('installments')
                                ->get()
                                ->when(Auth::user()->role->name == User::AGENT, fn ($q) => $q->where('agent_id', Auth::id()))
                                ->when(Auth::user()->role->name == User::CUSTOMER, fn ($q) => $q->where('customer_id', Auth::id()))
                                ->mapWithKeys(function ($insurance) {
                                    return [
                                        $insurance->id => insuranceCustomerPrefix($insurance->id).' - '.$insurance?->customer?->name,
                                    ];
                                })
                        )
                        ->afterStateUpdated(function ($get, $set, $state) {
                            $insurance = Insurance::find($state);
                            $isNotEmptyInstallment = ! empty($insurance?->installments()) ?? false;
                            $set('isNotEmptyInstallment', $isNotEmptyInstallment);
                        })
                        ->preload()
                        ->searchable()
                        ->native()
                        ->required(),
                    DatePicker::make('date')
                        ->label(__('messages.insurance_payment.form.payment_date'))
                        ->required()
                        ->default(today())
                        ->native(false)
                        ->maxDate(today()),
                    TextInput::make('amount')
                        ->label(__('messages.insurance_payment.form.amount'))
                        ->numeric()
                        ->readOnly()
                        ->extraInputAttributes(['oninput' => "this.value = this.value.replace(/[e\-]/gi, '')"])
                        ->placeholder(__('messages.insurance_payment.form.placeholder.amount'))
                        ->required(),
                    Select::make('status')
                        ->label(__('messages.insurance_payment.form.status'))
                        ->options(fn () => Auth::user()->hasRole(User::CUSTOMER) ? [InsurancePayment::PENDING => InsurancePayment::STATUSES[InsurancePayment::PENDING]] : InsurancePayment::STATUSES)
                        ->default(fn () => Auth::user()->hasRole(User::CUSTOMER) ? InsurancePayment::PENDING : null)
                        ->disableOptionWhen(fn ($value) => Auth::user()->hasRole(User::CUSTOMER) ? $value != InsurancePayment::PENDING : false)
                        ->native(false)
                        ->required(),
                    Select::make('installment_id')
                        ->label(__('messages.insurance_payment.form.installment'))
                        ->options(function ($get, $set) use ($usedInstallmentIds) {
                            $installments = Installment::where('insurance_id', $get('insurance_id'))
                                ->whereNotIn('id', $usedInstallmentIds)
                                ->with('payments')
                                ->get();

                            $data = $installments->mapWithKeys(fn ($installment) => [
                                $installment->id => sprintf(
                                    '%s - %s%s',
                                    $installment->order_no,
                                    currencySymbol(),
                                    number_format($installment->amount, 2)
                                ),
                            ]);

                            $set('default', key($data->toArray()));
                            $set('amount', $installments->first()?->amount ?? null);
                            $set('installment_id', key($data->toArray()));

                            return $data->toArray();
                        })
                        ->native(false)
                        ->default(fn ($get) => $get('default'))
                        ->placeholder(__('messages.insurance_payment.form.placeholder.installment'))
                        ->disabled(fn ($get) => ! $get('isNotEmptyInstallment'))
                        ->afterStateUpdated(function ($get, $set, $state) {
                            $installment = Installment::find($state);
                            $set('amount', $installment?->amount ?? null);
                        })
                        ->hintColor('info')
                        ->required(),
                ]),
            ])->live()->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                if (Auth::user()->role->name == User::CUSTOMER) {
                    return $query->whereHas('insurance', fn ($q) => $q->where('customer_id', Auth::id()));
                } elseif (Auth::user()->role->name == User::AGENT) {
                    return $query->whereHas('insurance', fn ($q) => $q->where('agent_id', Auth::id()));
                }

                return $query;
            })
            ->columns([
                TextColumn::make('insurance.customer.name')
                    ->label(__('messages.payment.customer'))
                    ->visible(Auth::user()->role->name != User::CUSTOMER)
                    ->sortable(),
                TextColumn::make('date')
                    ->label(__('messages.payment.payment_date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('messages.insurance.status'))
                    ->badge()
                    ->formatStateUsing(fn ($state) => InsurancePayment::STATUSES[$state])
                    ->color(fn ($state) => InsurancePayment::statusColor($state))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('insurance.id')
                    ->label(__('messages.payment.insurance'))
                    ->formatStateUsing(fn ($state, $record) => insuranceCustomerPrefix($state).' - '.$record->insurance?->customer?->name)
                    ->visible(Auth::user()->role->name != User::CUSTOMER)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('insurance.policy.tax.tax')
                    ->label(__('messages.payment.tax'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label(__('messages.payment.premium'))
                    ->prefix(currencySymbol())
                    ->sortable(),
                TextColumn::make('insurance.policyPricing.price')
                    ->label(__('messages.payment.total'))
                    ->prefix(currencySymbol())
                    ->sortable(),
            ])
            ->paginated([10, 25, 50, 100])
            ->filters([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePayments::route('/'),
        ];
    }
}
